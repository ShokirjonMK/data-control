<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseOrderModel;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_address".
 *
 * @property int $id
 * @property int $order_id
 * @property string $full_name
 * @property string $phone
 * @property string $address
 * @property string|null $city
 * @property string $region
 * @property string|null $zip
 * @property string $country
 * @property int $status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property Order $order
 */
class OrderAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_address';
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
            [['order_id', 'full_name', 'phone', 'address', 'region', 'country'], 'required'],
            [['order_id', 'status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['full_name', 'phone', 'address', 'city', 'region', 'zip', 'country'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
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
            'full_name' => 'Full Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'city' => 'City',
            'region' => 'Region',
            'zip' => 'Zip',
            'country' => 'Country',
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
     * {@inheritdoc}
     * @return \common\models\query\OrderAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\OrderAddressQuery(get_called_class());
    }

    public function create(?BaseOrderModel $form): ?OrderAddress
    {
        return $this->mapFormToModel($form, new self());
    }

    public function editData(?BaseOrderModel $form): void
    {
        $this->mapFormToModel($form, $this);
    }

    protected function  mapFormToModel(?BaseOrderModel $baseOrderModel, ?OrderAddress $model): ?OrderAddress
    {
        $model->order_id = $baseOrderModel->id;
        $model->full_name = $baseOrderModel->full_name;
        $model->phone = $baseOrderModel->phone;
        $model->address = $baseOrderModel->address;
        $model->city = $baseOrderModel->city;
        $model->region = $baseOrderModel->region;
        $model->country = $baseOrderModel->country;
        $model->zip = $baseOrderModel->zip;
        $model->status = 1;

        return $model;
    }
}
