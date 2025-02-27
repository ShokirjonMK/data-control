<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseSupplierBuyerModel;
use api\modules\v1\models\forms\SupplierBuyerCreateForm;
use api\modules\v1\models\forms\SupplierBuyerUpdateForm;
use common\models\query\EntityTypeQuery;
use Yii;

/**
 * This is the model class for table "entity_type".
 *
 * @property int $id
 * @property float|null $stock_percentage
 * @property int|null $stock_expiry
 * @property int $supplier_buyer_id
 * @property int $legal_entity
 *
 * @property SupplierBuyer $supplierBuyer
 */
class EntityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stock_percentage'], 'number'],
            [['stock_expiry', 'supplier_buyer_id'], 'integer'],
            [['legal_entity'], 'boolean'],
            [['supplier_buyer_id'], 'required'],
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
            'stock_percentage' => 'Stock Percentage',
            'stock_expiry' => 'Stock Expiry',
            'supplier_buyer_id' => 'ReceivingGoods Buyer ID',
            'legal_entity' => 'Legal Entity',
        ];
    }

    public function getSupplierBuyer()
    {
        return $this->hasOne(SupplierBuyer::class, ['id' => 'supplier_buyer_id']);
    }

    public static function find()
    {
        return new EntityTypeQuery(get_called_class());
    }

    public function create(?BaseSupplierBuyerModel $form): ?EntityType
    {
       return $this->mapFormToModel(new self(), $form);
    }

    public function editData(?BaseSupplierBuyerModel $form): void
    {
        $this->mapFormToModel($this, $form);
    }

    private function mapFormToModel(?EntityType $model, ?BaseSupplierBuyerModel $form): ?EntityType
    {
        $model->supplier_buyer_id = $form->id;
        $model->stock_percentage = $form->stock_percentage;
        $model->stock_expiry = $form->stock_expiry;
        $model->legal_entity = $form->legal_entity;

        return $model;
    }

}
