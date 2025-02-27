<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseSupplierBuyerModel;
use common\models\ContractBankDetails;
use common\models\EntityType;
use common\models\SupplierBuyer;
use common\models\SupplierBuyerStatus;
use common\models\TaxInfo;
use Exception;


class SupplierBuyerCreateForm extends BaseSupplierBuyerModel
{

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function createData(): void
    {

        executeTransaction(function () {

            $supplierBuyer = (new SupplierBuyer)->create($this);
            saveModel($supplierBuyer, 'supplierBuyer');

            $this->id = $supplierBuyer->id;

            $entityType = (new EntityType)->create($this);
            saveModel($entityType, 'entityType');

            $taxInfo = (new TaxInfo)->create($this);
            saveModel($taxInfo, 'taxInfo');

            $contractBankDetails = (new ContractBankDetails)->create($this);
            saveModel($contractBankDetails, 'contractBankDetails');

            $supplierBuyerStatus = (new SupplierBuyerStatus)->create($this);
            saveModel($supplierBuyerStatus, 'supplierBuyerStatus');
        });
    }
}