<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseSupplierModel;
use api\modules\v1\models\forms\SupplierCreateForm;
use api\modules\v1\models\forms\SupplierUpdateForm;
use Yii;

/**
 * This is the model class for table "supplier_details".
 *
 * @property int $id
 * @property int $supplier_id
 * @property string|null $kis_number
 * @property string|null $kis_date
 * @property bool|null $accept_by_places
 * @property string|null $vehicle_type
 * @property float|null $vat_rate
 * @property float|null $vat_amount
 * @property bool|null $price_includes_vat
 * @property float|null $discount_amount
 * @property float|null $under_delivery_percent
 * @property float|null $over_delivery_percent
 *
 * @property Supplier $supplier
 */
class SupplierDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id'], 'required'],
            [['supplier_id'], 'default', 'value' => null],
            [['supplier_id'], 'integer'],
            [['kis_date'], 'safe'],
            [['accept_by_places', 'price_includes_vat'], 'boolean'],
            [['vat_rate', 'vat_amount', 'discount_amount', 'under_delivery_percent', 'over_delivery_percent'], 'number'],
            [['kis_number', 'vehicle_type'], 'string', 'max' => 255],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::class, 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'ReceivingGoods ID',
            'kis_number' => 'Kis Number',
            'kis_date' => 'Kis Date',
            'accept_by_places' => 'Accept By Places',
            'vehicle_type' => 'Vehicle Type',
            'vat_rate' => 'Vat Rate',
            'vat_amount' => 'Vat Amount',
            'price_includes_vat' => 'Price Includes Vat',
            'discount_amount' => 'Discount Amount',
            'under_delivery_percent' => 'Under Delivery Percent',
            'over_delivery_percent' => 'Over Delivery Percent',
        ];
    }

    public function getSupplier()
    {
        return $this->hasOne(Supplier::class, ['id' => 'supplier_id']);
    }

    public static function find()
    {
        return new \common\models\query\SupplierDetailsQuery(get_called_class());
    }

    public function create(?BaseSupplierModel $form): SupplierDetails
    {
       return  $this->mapFormToModel(new self(), $form);
    }

    public function editData(?BaseSupplierModel $form): void
    {
        $this->mapFormToModel($this, $form);
    }

    protected function mapFormToModel(?SupplierDetails $model, ?BaseSupplierModel $form): ?SupplierDetails
    {

        $model->supplier_id = $form->id;
        $model->kis_number = $form->kis_number;
        $model->kis_date = $form->kis_date;
        $model->accept_by_places = $form->accept_by_places;
        $model->vehicle_type = $form->vehicle_type;
        $model->vat_rate = $form->vat_rate;
        $model->vat_amount = $form->vat_amount;
        $model->price_includes_vat = $form->price_includes_vat;
        $model->discount_amount = $form->discount_amount;
        $model->under_delivery_percent = $form->under_delivery_percent;
        $model->over_delivery_percent = $form->over_delivery_percent;

        return $model;

    }
}

