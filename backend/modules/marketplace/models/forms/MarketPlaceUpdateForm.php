<?php declare(strict_types=1);

namespace backend\modules\marketplace\models\forms;

use api\modules\v1\models\forms\SupplierBuyerUpdateForm;
use common\models\SupplierBuyer;
use yii\db\Exception;

class MarketPlaceUpdateForm extends SupplierBuyerUpdateForm
{
    public function __construct(SupplierBuyer $supplierBuyer, $config = [])
    {
        $this->group = $supplierBuyer->group;
        $this->code = $supplierBuyer->code;
        $this->name = $supplierBuyer->name;
        $this->full_name = $supplierBuyer->full_name;
        $this->name_eng = $supplierBuyer->name_eng;
        $this->main_delivery_address = $supplierBuyer->contractBankDetail->main_delivery_address;
        $this->stock_percentage = $supplierBuyer->entityType->stock_percentage;
        $this->stock_expiry = $supplierBuyer->entityType->stock_expiry;
        $this->legal_entity = $supplierBuyer->entityType->legal_entity;
        $this->is_supplier = $supplierBuyer->supplierBuyerStatus->is_supplier;
        $this->is_buyer = $supplierBuyer->supplierBuyerStatus->is_buyer;
        $this->depositor = $supplierBuyer->supplierBuyerStatus->depositor;
        $this->contract_date = $supplierBuyer->contractBankDetail->contract_date;
        $this->bank_details = $supplierBuyer->contractBankDetail->bank_details;
        $this->contact_info = $supplierBuyer->contractBankDetail->contact_info;
        $this->additional_details = $supplierBuyer->contractBankDetail->additional_details;
        $this->contract_number = $supplierBuyer->contractBankDetail->contract_number;
        $this->inn = $supplierBuyer->taxInfo->inn;
        $this->kpp = $supplierBuyer->taxInfo->kpp;
        $this->okpo = $supplierBuyer->taxInfo->okpo;


        parent::__construct($supplierBuyer, $config);
    }

    /**
     * @throws Exception
     */
    public function update(): void
    {
       executeTransaction(function () {
           $this->updateData();
       });
    }
}