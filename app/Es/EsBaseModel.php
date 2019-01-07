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
        $this->client = $client = ClientBuilder::create()->build();
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

}