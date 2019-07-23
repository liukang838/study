<?php

namespace App\Libs\NmredKafka;

use Kafka\Producer;
use Kafka\ProducerConfig;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/7/23
 * Time: 下午3:48
 */
class MyProducer
{
    private $producer;
    private $topic;
    private $message = 'wocao';

    public function __construct($topic = 'test', $message = 'fuck!')
    {
        ProducerConfig::getInstance()->setMetadataBrokerList('localhost:9092');
        $this->topic = $topic;
        $this->message = $message;
    }

    public function handle()
    {
        $this->producer = new Producer(function () {
            return [
                [
                    'topic' => $this->topic,
                    'value' => $this->message
                ],
            ];
        });

        $this->producer->success(function ($result) {
            var_dump($result);
        });

        $this->producer->error(function ($errorCode) {
            var_dump($errorCode);
        });

        return $this->producer->send(true);
    }
}
