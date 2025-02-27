<?php

return [
    'class' => yii\queue\db\Queue::class,
    'db' => 'db',
    'tableName' => '{{%queue}}',
    'channel' => 'default',
    'ttr' => 60,
    'attempts' => 5,
    'mutex' => yii\mutex\PgsqlMutex::class,
];
