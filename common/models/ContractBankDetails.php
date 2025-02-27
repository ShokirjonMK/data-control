<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseSupplierBuyerModel;
use api\modules\v1\models\forms\SupplierBuyerCreateForm;
use api\modules\v1\models\forms\SupplierBuyerUpdateForm;
use common\models\query\ContractBankDetailsQuery;
use Yii;

/**
 * This is the model class for table "contract_bank_details".
 *
 * @property int $id
 * @property int $supplier_buyer_id
 * @property string|null $contract_number
 * @property string|null $contract_date
 * @property string|null $bank_details
 * @property string|null $contact_info
 * @property string|null $additional_details
 * @property string|null $main_delivery_address
 *
 * @property SupplierBuyer $supplierBuyer
 */
class ContractBankDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_bank_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_buyer_id'], 'required'],
            [['supplier_buyer_id'], 'default', 'value' => null],
            [['supplier_buyer_id'], 'integer'],
            [['contract_date'], 'safe'],
            [['bank_details', 'contact_info', 'additional_details'], 'string'],
            [['contract_number'], 'string', 'max' => 100],
            [['main_delivery_address'], 'string', 'max' => 255],
            [['supplier_buyer_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierBuyer::class, 'targetAttribute' => ['supplier_buyer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_buyer_id' => 'ReceivingGoods Buyer ID',
            'contract_number' => 'Contract Number',
            'contract_date' => 'Contract Date',
            'bank_details' => 'Bank Details',
            'contact_info' => 'Contact Info',
            'additional_details' => 'Additional Details',
            'main_delivery_address' => 'Main Delivery Address',
        ];
    }

    public function getSupplierBuyer()
    {
        return $this->hasOne(SupplierBuyer::class, ['id' => 'supplier_buyer_id']);
    }

    public static function find()
    {
        return new ContractBankDetailsQuery(get_called_class());
    }

    public function create(?BaseSupplierBuyerModel $form): ?ContractBankDetails
    {
       return $this->mapFormToModel(new self(), $form);
    }

    public function editData(?BaseSupplierBuyerModel $form): void
    {
       $this->mapFormToModel($this, $form);
    }

    protected function mapFormToModel(?ContractBankDetails $model, ?BaseSupplierBuyerModel $form): ?ContractBankDetails
    {
        $model->supplier_buyer_id = $form->id;
        $model->contract_number = $form->contract_number;
        $model->contract_date = $form->contract_date;
        $model->bank_details = $form->bank_details;
        $model->contact_info = $form->contact_info;
        $model->additional_details = $form->additional_details;
        $model->main_delivery_address = $form->main_delivery_address;

        return $model;
    }
}
