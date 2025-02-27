<?php

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseStatusModel;
use common\models\Product;

class ProductStatusCustomerForm extends BaseStatusModel
{
    protected function getStatusField(): string
    {
        return 'customer_status';
    }

    protected function getModelClass(): string
    {
        return Product::class;
    }
}