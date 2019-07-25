<?php

namespace App\Libs\NmredKafka;

use Kafka\ProducerConfig;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/7/23
 * Time: 下午5:54
 */
class MyKafka
{
    public $config;

    public function __construct()
    {
        $this->config = ProducerConfig::getInstance();
        $this->config->setMetadataBrokerList('localhost:9092');
    }
}
