<?php declare(strict_types=1);

namespace api\modules\v1\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Supplier extends \common\models\Supplier implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'number',
            'date',
            'counterparty',
            'arrival_date',
            'comment',
            'vehicle_model',
            'vehicle_number',
            'driver_name',
            'driver_document',
            'contract_number',
            'contract_date',
            'acceptance_gate',
            'nomenclature',
            'quantity',
            'price',
            'total_amount',
            'supplierDetail',
            'supplierPackage'
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['receiving-goods/view', 'id' => $this->id], true)
        ];
    }
}
