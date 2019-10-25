<?php

namespace App\Es;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/1/7
 * Time: 下午6:04
 */
class EsArticleModel extends EsBaseModel
{
    protected $index = 'study';

    protected $type = 'article';

    function __construct()
    {
        parent::__construct($this->index, $this->type);
    }

    /**
     * @param $title
     * @return array|mixed
     */
    public function getByTitle($title)
    {
        $params = [
            'query' =>
                [
                    'constant_score' =>
                        [
                            'filter' => ['term' =>
                                [
                                    'title' => $title
                                ]
                            ]
                        ]
                ]
        ];

        return $this->search($params);
    }

    public function findByCon($title, $content)
    {

//        $params = [
//            'query' => [
//                'bool' => [
////                    'must' => [
////                        'match' => [
////                            'title' => 'abcd'
////                        ]
////                    ],
//                    'must' => [
//                        'match' => [
//                            'content' => '非常电视剧'
//                        ]
//                    ]
//                ]
//
//            ]
//        ];

        $params = [
            'query' => [
                'constant_score' => [
                    'filter' => [
                        'bool' => [
                            'must' =>
                                [
                                    'match' => ['content' => '非常 mmp']
                                ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->search($params);
    }
}
