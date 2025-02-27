<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseSupplierBuyerModel;
use api\modules\v1\models\forms\SupplierBuyerCreateForm;
use api\modules\v1\models\forms\SupplierBuyerUpdateForm;
use common\models\query\TaxInfoQuery;
use Yii;

/**
 * This is the model class for table "tax_info".
 *
 * @property int $id
 * @property int $supplier_buyer_id
 * @property string|null $inn
 * @property string|null $kpp
 * @property string|null $okpo
 *
 * @property SupplierBuyer $supplierBuyer
 */
class TaxInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tax_info';
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
            [['inn', 'kpp', 'okpo'], 'string', 'max' => 20],
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
            'inn' => 'Inn',
            'kpp' => 'Kpp',
            'okpo' => 'Okpo',
        ];
    }

    public function getSupplierBuyer()
    {
        return $this->hasOne(SupplierBuyer::class, ['id' => 'supplier_buyer_id']);
    }

    public static function find()
    {
        return new TaxInfoQuery(get_called_class());
    }

    public function create(?BaseSupplierBuyerModel $form): ?TaxInfo
    {
        return $this->mapFormToModel(new self(), $form);
    }

    public function editData(?BaseSupplierBuyerModel $form): void
    {
        $this->mapFormToModel($this, $form);
    }

    private function mapFormToModel(?TaxInfo $model, ?BaseSupplierBuyerModel $form): ?TaxInfo
    {
        $model->supplier_buyer_id = $form->id;
        $model->inn = $form->inn;
        $model->kpp = $form->kpp;
        $model->okpo = $form->okpo;

        return $model;
    }
}
