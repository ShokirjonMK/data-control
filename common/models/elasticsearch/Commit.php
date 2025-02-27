<?php

namespace common\models\elasticsearch;

use yii\elasticsearch\ActiveRecord;

class Commit extends ActiveRecord
{
    public static function index()
    {
        return 'commit';
    }

    public static function type()
    {
        return '_doc';
    }

    public function attributes()
    {
        return ['id', 'email', 'phone', 'address'];
    }
}