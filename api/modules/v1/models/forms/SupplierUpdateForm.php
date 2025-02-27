<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseSupplierModel;
use common\models\Supplier;
use Exception;

class SupplierUpdateForm extends BaseSupplierModel
{
    public function __construct(private readonly Supplier $supplier, $config = [])
    {
        $this->id = $supplier->id;
        parent::__construct($config);
    }

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function updateData(): void
    {
       executeTransaction(function () {

           $this->supplier->editData($this);
           updateModel($this->supplier, 'supplier');

           $this->supplier->supplierDetail->editData($this);
           updateModel($this->supplier->supplierDetail, 'supplierDetail');

           $this->supplier->supplierPackage->editData($this);
           updateModel($this->supplier->supplierPackage, 'supplierPackage');
       });
    }

}