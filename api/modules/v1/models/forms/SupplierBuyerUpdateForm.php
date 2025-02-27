<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseSupplierBuyerModel;
use common\models\SupplierBuyer;
use Exception;

class SupplierBuyerUpdateForm extends BaseSupplierBuyerModel
{
    public function __construct(private readonly SupplierBuyer $supplierBuyer, $config = [])
    {
        $this->id = $supplierBuyer->id;
        parent::__construct($config);
    }

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function updateData(): void
    {
        executeTransaction(function () {

            $this->supplierBuyer->editData($this);
            updateModel($this->supplierBuyer, 'supplierBuyer');

            $this->supplierBuyer->entityType->editData($this);
            updateModel($this->supplierBuyer->entityType, 'entityType');

            $this->supplierBuyer->taxInfo->editData($this);
            updateModel($this->supplierBuyer->taxInfo, 'taxInfo');

            $this->supplierBuyer->contractBankDetail->editData($this);
            updateModel($this->supplierBuyer->contractBankDetail, 'contractBankDetails');

            $this->supplierBuyer->supplierBuyerStatus->editData($this);
            updateModel($this->supplierBuyer->supplierBuyerStatus, 'supplierBuyerStatus');

        });
    }
}