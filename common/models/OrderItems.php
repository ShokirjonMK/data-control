<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseOrderModel;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_items".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property int|null $quantity
 * @property int|null $price
 * @property int $status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property Order $order
 * @property Product $product
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_items';
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
            [['order_id', 'product_id', 'quantity', 'price', 'status'], 'integer'],
            [['product_id', 'quantity', 'price'], 'required'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\OrderQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
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
     * {@inheritdoc}
     * @return \common\models\query\OrderItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\OrderItemsQuery(get_called_class());
    }

    public function create(?array $form, ?BaseOrderModel $model)
    {
        return $this->mapFormToModel($form, $model, new self());
    }

    public function editData(?array $form, ?BaseOrderModel $model)
    {
        $this->mapFormToModel($form, $model, $this);
    }

    protected function  mapFormToModel(?array $baseOrderModel, ?BaseOrderModel $modelForm, ?OrderItems $model): ?OrderItems
    {
        $model->order_id = $modelForm->id;
        $model->product_id = $baseOrderModel['product_id'];
        $model->quantity = $baseOrderModel['quantity'];
        $model->price = $baseOrderModel['price'];

        return $model;
    }

}
