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
        $params = ['query' => [
            'bool' => [
                'should' => [
                    'match' => ['title' => $title]
                ]
            ]
        ]
        ];

        return $this->search($params);
    }
}
