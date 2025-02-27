<?php

namespace api\modules\v1\resources;

class OrderAddress extends \common\models\OrderAddress
{
    public function fields()
    {
        return [
            'id',
            'order_id',
            'full_name',
            'phone',
            'address',
            'city',
            'region',
            'zip',
            'country',
            'status',
        ];
    }
}