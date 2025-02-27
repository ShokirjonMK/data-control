<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseSupplierModel;
use api\modules\v1\models\forms\SupplierCreateForm;
use api\modules\v1\models\forms\SupplierUpdateForm;
use Yii;

/**
 * This is the model class for table "supplier_package".
 *
 * @property int $id
 * @property int $supplier_id
 * @property string|null $nomenclature_package
 * @property int|null $package_quantity
 *
 * @property Supplier $supplier
 */
class SupplierPackage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_package';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id'], 'required'],
            [['supplier_id', 'package_quantity'], 'default', 'value' => null],
            [['supplier_id', 'package_quantity'], 'integer'],
            [['nomenclature_package'], 'string', 'max' => 255],
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
            'nomenclature_package' => 'Nomenclature Package',
            'package_quantity' => 'Package Quantity',
        ];
    }

    public function getSupplier()
    {
        return $this->hasOne(Supplier::class, ['id' => 'supplier_id']);
    }


    public static function find()
    {
        return new \common\models\query\SupplierPackageQuery(get_called_class());
    }

    public function create(?BaseSupplierModel $form): SupplierPackage
    {
       return $this->mapFormToModel(new self(), $form);
    }

    public function editData(?BaseSupplierModel $form): void
    {
        $this->mapFormToModel($this, $form);
    }

    protected function mapFormToModel(?SupplierPackage $model, ?BaseSupplierModel $form): ?SupplierPackage
    {
        $model->supplier_id = $form->id;
        $model->nomenclature_package = $form->nomenclature_package;
        $model->package_quantity = $form->package_quantity;

        return $model;

    }
}
