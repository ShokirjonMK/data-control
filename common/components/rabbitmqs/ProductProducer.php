<?php

namespace common\components\rabbitmqs;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;

class ProductProducer
{
    public function sendProduct($data)
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
        $channel = $connection->channel();

        $channel->queue_declare('product_queue', false, false, false, false);

        $msg = new AMQPMessage(json_encode($data));
        $channel->basic_publish($msg, '', 'product_queue');

        Yii::info("Sent product to RabbitMQ: " . json_encode($data), __METHOD__);

        $channel->close();
        $connection->close();
    }
}