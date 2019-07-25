<?php

namespace App\Libs\NmredKafka;

use Kafka\Consumer;
use Kafka\ProducerConfig;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/7/23
 * Time: 下午3:48
 */
class MyConsumer extends MyKafka
{
    private $consumer;
    private $topic;
    private $message = 'wocao';

    public function __construct($topic = 'test', $message = 'fuck!')
    {
        parent::__construct();
        $this->topic = $topic;
        $this->message = $message;

        $this->config->setGroupId('group1');
        $this->config->setTopics([$this->topic]);
        $this->config->setOffsetReset('latest');
    }

    public function handle()
    {
        $this->consumer = new Consumer();

        return $this->consumer->start(function ($topic, $part, $message) {
            var_dump($message);
        });
    }
}
