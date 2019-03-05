<?php
/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/3/4
 * Time: 上午11:46
 */

namespace App\Models;

class KafkaModel extends BaseModel
{
    public $broker_list = 'localhost:9092';
    public $topic = 'test';
    public $partition = 0;
    protected $producer = null;
    protected $consumer = null;

    public function __construct()
    {
        parent::__construct();

        if (empty($this->broker_list)) {
            throw new \Exception('kafka broker not config');
        }

        $rk = new \RdKafka\Producer();
        if (empty($rk)) {
            throw new \Exception('producer error');
        }
        $rk->setLogLevel(LOG_DEBUG);
        if (!$rk->addBrokers($this->broker_list)) {
            throw new \Exception('addBrokers error');
        }
        $this->producer = $rk;
    }

    public function sendMessage($array_message = [])
    {
        $topic = $this->producer->newTopic($this->topic);
        return $topic->produce(RD_KAFKA_PARTITION_UA, $this->partition, json_encode($array_message));
    }

    public function getMessage()
    {
        $rk = new \RdKafka\Consumer();
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($this->broker_list);

        $topic = $rk->newTopic($this->topic);
        $topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

        while (true) {
            // The first argument is the partition (again).
            // The second argument is the timeout.
            $msg = $topic->consume(0, 1000);
            if ($msg->err) {
                echo $msg->errstr(), "\n";
                break;
            } else {
                echo $msg->payload, "\n";
            }
        }
    }

}

