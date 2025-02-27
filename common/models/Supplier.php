<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseSupplierModel;
use api\modules\v1\models\forms\SupplierCreateForm;
use api\modules\v1\models\forms\SupplierUpdateForm;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $number
 * @property string $date
 * @property string $counterparty
 * @property string|null $arrival_date
 * @property string|null $comment
 * @property string|null $vehicle_model
 * @property string|null $vehicle_number
 * @property string|null $driver_name
 * @property string|null $driver_document
 * @property string|null $contract_number
 * @property string|null $contract_date
 * @property string|null $acceptance_gate
 * @property string $nomenclature
 * @property int $quantity
 * @property float $price
 * @property float $total_amount
 * @property int $status
 * @property int $customer_status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property SupplierDetails $supplierDetail
 * @property SupplierPackage $supplierPackage
 */
class Supplier extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 1;
    const STATUS_APPROVED = 2;
    const STATUS_DELIVERED = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
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
            [['number', 'date', 'counterparty', 'nomenclature', 'quantity', 'price', 'total_amount'], 'required'],
            [['date', 'arrival_date', 'contract_date'], 'safe'],
            [['comment'], 'string'],
            [['quantity'], 'default', 'value' => null],
            [['quantity', 'customer_status', 'status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['price', 'total_amount'], 'number'],
            [['number', 'counterparty', 'vehicle_model', 'vehicle_number', 'driver_name', 'driver_document', 'contract_number', 'acceptance_gate', 'nomenclature'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'counterparty' => 'Counterparty',
            'arrival_date' => 'Arrival Date',
            'comment' => 'Comment',
            'vehicle_model' => 'Vehicle Model',
            'vehicle_number' => 'Vehicle Number',
            'driver_name' => 'Driver Name',
            'driver_document' => 'Driver Document',
            'contract_number' => 'Contract Number',
            'contract_date' => 'Contract Date',
            'acceptance_gate' => 'Acceptance Gate',
            'nomenclature' => 'Nomenclature',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'total_amount' => 'Total Amount',
        ];
    }

    public function getSupplierDetail()
    {
        return $this->hasOne(SupplierDetails::class, ['supplier_id' => 'id']);
    }

    public function getSupplierPackage()
    {
        return $this->hasOne(SupplierPackage::class, ['supplier_id' => 'id']);
    }


    public static function find()
    {
        return new \common\models\query\SupplierQuery(get_called_class());
    }

    public function create(?BaseSupplierModel $form): ?Supplier
    {
       return $this->mapFormToModel(new self(), $form);
    }

    public function editData(?BaseSupplierModel $form): void
    {
        $this->mapFormToModel($this, $form);
    }

    protected function mapFormToModel(?Supplier $model, ?BaseSupplierModel $form): ?Supplier
    {
        $model->number = $form->number;
        $model->date = $form->date;
        $model->price  = $form->price;
        $model->quantity = $form->quantity;
        $model->counterparty = $form->counterparty;
        $model->arrival_date = $form->arrival_date;
        $model->comment = $form->comment;
        $model->vehicle_model = $form->vehicle_model;
        $model->vehicle_number = $form->vehicle_number;
        $model->driver_name = $form->driver_name;
        $model->driver_document = $form->driver_document;
        $model->contract_number = $form->contract_number;
        $model->contract_date = $form->contract_date;
        $model->nomenclature = $form->nomenclature;
        $model->total_amount = $form->total_amount;
        $model->status = 1;

        return $model;

    }
}
