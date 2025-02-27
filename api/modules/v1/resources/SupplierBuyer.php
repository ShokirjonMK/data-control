<?php declare(strict_types=1);

namespace api\modules\v1\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class SupplierBuyer extends \common\models\SupplierBuyer implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'group',
            'code',
            'name',
            'full_name',
            'name_eng',
            'contractBankDetail',
            'entityType',
            'supplierBuyerStatus',
            'taxInfo',
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['purveyor/view', 'id' => $this->id], true)
        ];
    }
}
