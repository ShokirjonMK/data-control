<?php

return [
    'definitions' => [
        \common\services\WebhookService::class => function ($container) {
            return new \common\services\WebhookService(new \yii\httpclient\Client());
        },
        \common\services\JsonSerializer::class => function ($container) {
            return new \common\services\JsonSerializer();
        },
    ]
];