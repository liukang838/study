<?php

namespace App\Es;

use Elasticsearch\ClientBuilder;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/1/7
 * Time: 下午6:04
 */
class EsBaseModel
{
    protected static $_instance = [];

    protected $index;

    protected $type;

    private $client;

    function __construct($index, $type)
    {
        $this->index = $index;
        $this->type = $type;
        $this->setClient();
    }

    public static function getInstance()
    {
        $class = get_called_class();
        if (empty(self::$_instance[$class])) {
            self::$_instance[$class] = new static();
        }
        return self::$_instance[$class];
    }

    private function setClient()
    {
        $hosts = [
            [
                'host' => '47.104.64.164',
                'port' => '9200',
                'scheme' => 'http',
                'user' => '',
                'pass' => ''
            ]
        ];

        $this->client = $client = ClientBuilder::create()->setHosts($hosts)->build();
    }

    /**
     * 通过ID查询单条记录
     *
     * @param $id
     * @return array|mixed
     */
    public function findBy($id)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id,
            'client' => ['ignore' => [400, 404]]
        ];

        $ret = $this->client->get($params);
        $isSuccess = array_get($ret, 'found', false);
        if (!$isSuccess) return [];
        return array_get($ret, '_source');
    }

    /**
     * 查询(search)
     *
     * @param array $matchArr
     * @desc or多条件查询 ['match'=>['content' => 'keyword1 keyword2']]；and的多条件查询['match'=>['content' => 'keyword1'],'match'=>['title'=>'keyword2']
     * @return array
     */
    public function search(array $matchArr, $page = null, $perPage = null)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'client' => ['ignore' => [400, 404]],
            'body' => [
                'query' => $matchArr
            ]
        ];

        if (!is_null($page) && !is_null($perPage)) {
            $params = array_push($params, ['from' => $page * $perPage, 'size' => $perPage]);
        }

        $ret = $this->client->search($params);

        $total = array_get($ret['hits'], 'total', 0);
        if ($total == 0) return [];

        return array_pluck(array_get($ret['hits'], 'hits', []), '_source');
    }


}
