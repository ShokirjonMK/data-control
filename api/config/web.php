<?php

$config = [
    'homeUrl' => Yii::getAlias('@apiUrl'),
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'timeZone' => 'Asia/Tashkent',
    'modules' => require(__DIR__ . '/_modules.php'),
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => common\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                if (env('APP_MAINTENANCE') === '1') {
                    return true;
                }
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => null,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => 'identity-user',
                'path' => '/',
            ],
        ]
    ],
];

return $config;