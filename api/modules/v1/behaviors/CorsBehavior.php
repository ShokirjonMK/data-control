<?php

namespace api\modules\v1\behaviors;

use yii\filters\Cors;

class CorsBehavior extends Cors
{
    public function init()
    {
        parent::init();
        $origins = explode(',', env('CORS_ORIGINS', 'http://localhost,http://127.0.0.1'));

        $this->cors = [
            'Origin' => $origins,
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
            'Access-Control-Allow-Credentials' => true,
            'Access-Control-Max-Age' => 3600,
            'Access-Control-Allow-Headers' => ['Authorization', 'Content-Type', 'X-Requested-With'],
        ];
    }
}