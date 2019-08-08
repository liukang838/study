<?php

namespace App\Es;

use Elasticsearch\Client;
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

    protected $params;

    /**
     * @var Client
     */
    protected $client;

    function __construct($index, $type)
    {
        $this->index = $index;
        $this->type = $type;
        $this->setClient();

        $this->params = [
            'index' => $this->index,
            'type' => $this->type,
            'client' => ['ignore' => [400, 404]]
        ];
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

        $client = ClientBuilder::create()->setHosts($hosts)->build();
        $this->client = $client;
    }

    /**
     * 设置参数
     *
     * @param $key
     * @param $value
     */
    public function setParams($key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * 通过ID查询单条记录
     *
     * @param $id
     * @return array|mixed
     */
    public function findBy($id)
    {
        $this->setParams('id', $id);
        $ret = $this->client->get($this->params);
        $isSuccess = array_get($ret, 'found', false);
        if (!$isSuccess) return [];
        return array_get($ret, '_source');
    }

    /**
     * 创建数据
     *
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        $params['body'] = $data;
        $params['index'] = $this->index;
        $params['type'] = $this->type;

        return $this->client->index($params);
    }

    public function search($params)
    {
        $this->setParams('body', $params);
        $ret = $this->client->search($this->params);
dd($ret);
        $total = array_get($ret['hits'], 'total', 0);
        if ($total == 0) return [];

        return array_get($ret['hits'], 'hits', []);
    }
}
