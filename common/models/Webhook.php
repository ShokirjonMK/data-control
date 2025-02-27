<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webhook".
 *
 * @property int $id
 * @property int|null $supplier_buyer_id
 * @property string|null $url
 * @property string|null $token
 * @property int|null $status
 *
 * @property SupplierBuyer $supplierBuyer
 */
class Webhook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webhook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_buyer_id', 'status'], 'default', 'value' => null],
            [['supplier_buyer_id', 'status'], 'integer'],
            [['url', 'token'], 'string', 'max' => 255],
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
            'supplier_buyer_id' => 'Supplier Buyer ID',
            'url' => 'Url',
            'token' => 'Token',
            'status' => 'Status',
        ];
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

    /**
     * {@inheritdoc}
     * @return \common\models\query\WebhookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WebhookQuery(get_called_class());
    }
}
