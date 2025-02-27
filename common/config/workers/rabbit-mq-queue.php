<?php

return [
    'class' => \yii\queue\amqp\Queue::class,
    'as log' => \yii\queue\LogBehavior::class,
    'host' => 'rabbitmq',
    'port' => 5672,
    'user' => 'user',
    'password' => 'password',
    'queueName' => 'product',
];
