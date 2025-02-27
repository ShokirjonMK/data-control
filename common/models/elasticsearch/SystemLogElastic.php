<?php

namespace common\models\elasticsearch;

use yii\elasticsearch\ActiveRecord;

class SystemLogElastic extends ActiveRecord
{
    public static function index()
    {
        return 'system_log';
    }

    public static function type()
    {
        return '_doc';
    }

    public function attributes()
    {
        return ['id', 'level', 'category', 'log_time', 'message'];
    }
}