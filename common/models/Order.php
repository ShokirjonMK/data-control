<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseOrderModel;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $order_id
 * @property int|null $supplier_buyer_id
 * @property int $status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int $quantity
 * @property int $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int|null $delivery_status
 * @property int|null $fulfillment_status
 *
 * @property OrderAddress $orderAddress
 * @property OrderItems[] $orderItems
 * @property Product $product
 * @property SupplierBuyer $supplierBuyer
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
            [
                'class' => BlameableBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'supplier_buyer_id', 'status', 'delivery_status', 'fulfillment_status'], 'integer'],
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
            'product_id' => 'Product ID',
            'order_id' => 'Order ID',
            'supplier_buyer_id' => 'Supplier Buyer ID',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'delivery_status' => 'Delivery Status',
            'fulfillment_status' => 'Fulfillment Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }

    public function getOrderAddress()
    {
        return $this->hasOne(\api\modules\v1\resources\OrderAddress::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[SupplierBuyer]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SupplierBuyerQuery
     */
    public function getSupplierBuyer()
    {
        return $this->hasOne(SupplierBuyer::class, ['id' => 'supplier_buyer_id']);
    }

    public function getOrderItems()
    {
        return $this->hasMany(\api\modules\v1\resources\OrderItems::class, ['order_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\OrderQuery(get_called_class());
    }

    public function create(?BaseOrderModel $form): ?Order
    {
        return $this->mapFormToModel($form, new self());
    }

    public function editData(?BaseOrderModel $form): void
    {
        $this->mapFormToModel($form, $this);
    }

    protected function  mapFormToModel(?BaseOrderModel $baseOrderModel, ?Order $model): ?Order
    {
        $model->order_id = $baseOrderModel->order_id;
        $model->status = 1;
        $model->supplier_buyer_id = supplierBuyerIdentityId();

        return $model;
    }

}
