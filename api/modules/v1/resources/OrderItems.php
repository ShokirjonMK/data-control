<?php

namespace api\modules\v1\resources;

class OrderItems extends \common\models\OrderItems
{
    public function fields()
    {
        return [
            'id',
            'order_id',
            'product_id',
            'quantity',
            'price',
            'status',
        ];
    }
}