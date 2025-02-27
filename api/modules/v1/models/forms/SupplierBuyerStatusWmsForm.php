<?php

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseStatusModel;
use common\models\SupplierBuyer;

class SupplierBuyerStatusWmsForm extends BaseStatusModel
{
    protected function getStatusField(): string
    {
        return 'status';
    }

    protected function getModelClass(): string
    {
        return SupplierBuyer::class;
    }
}