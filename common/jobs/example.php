<?php

namespace common\jobs;

use api\modules\v1\models\forms\LoginForm;
use common\services\JsonSerializer;
use Yii;

class example
{
    public function run()
    {
        $modelForm = new LoginForm();
        Yii::$app->queue->channel = 'webhook';
        Yii::$app->queue->push(new RetryableWebhookJob([
            'webhookUrl' => 'http://wms.bts.uz:8040/v1/auth/login',
            'payload' => Yii::$container->get(JsonSerializer::class)->serialize($modelForm),
        ]));
    }
}