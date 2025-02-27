<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseSupplierModel;
use common\models\Supplier;
use common\models\SupplierDetails;
use common\models\SupplierPackage;
use Exception;

class SupplierCreateForm extends BaseSupplierModel
{
    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function createData(): void
    {
       executeTransaction(function () {

           $supplier = (new Supplier())->create($this);
           saveModel($supplier, 'Supplier');

           $this->id = $supplier->id;

           $supplierDetails = (new SupplierDetails())->create($this);
           saveModel($supplierDetails, 'SupplierDetails');

           $supplierPackage = (new SupplierPackage())->create($this);
           saveModel($supplierPackage, 'SupplierPackage');
       });
    }
}