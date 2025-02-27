<?php

namespace api\modules\v1\resources;

use Yii;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Order extends \common\models\Order implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'order_id',
            'supplier_buyer_id',
            'order_status' => 'status',
            'created_at' => function () {
                return Yii::$app->formatter->asDate($this->created_at, 'php:Y-m-d H:i:s');
            },
            'orderAddress',
            'orderItems'
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['order/view', 'id' => $this->id], true)
        ];
    }
}
