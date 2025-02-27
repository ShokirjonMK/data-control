<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseSupplierBuyerModel;
use api\modules\v1\models\forms\SupplierBuyerCreateForm;
use api\modules\v1\models\forms\SupplierBuyerUpdateForm;
use common\models\query\SupplierBuyerStatusQuery;
use Yii;

/**
 * This is the model class for table "supplier_buyer_status".
 *
 * @property int $id
 * @property int $supplier_buyer_id
 * @property bool $is_supplier
 * @property bool $is_buyer
 * @property bool|null $depositor
 *
 * @property SupplierBuyer $supplierBuyer
 */
class SupplierBuyerStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_buyer_status';
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
            [['is_supplier', 'is_buyer', 'depositor'], 'boolean'],
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
            'is_supplier' => 'Is ReceivingGoods',
            'is_buyer' => 'Is Buyer',
            'depositor' => 'Depositor',
        ];
    }

    public function getSupplierBuyer()
    {
        return $this->hasOne(SupplierBuyer::class, ['id' => 'supplier_buyer_id']);
    }

    public static function find()
    {
        return new SupplierBuyerStatusQuery(get_called_class());
    }

    public function create(?BaseSupplierBuyerModel $form): ?SupplierBuyerStatus
    {
       return $this->mapFormToModel(new self(), $form);
    }

    public function editData(?BaseSupplierBuyerModel $form): void
    {
       $this->mapFormToModel($this, $form);
    }

    private function mapFormToModel(?SupplierBuyerStatus $model, ?BaseSupplierBuyerModel $form): ?SupplierBuyerStatus
    {
        $model->supplier_buyer_id = $form->id;
        $model->is_supplier = $form->is_supplier;
        $model->is_buyer = $form->is_buyer;
        $model->depositor = $form->depositor;

        return $model;
    }
}
