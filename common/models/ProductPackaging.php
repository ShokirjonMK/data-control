<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseProductModel;
use api\modules\v1\models\forms\ProductCreateForm;
use api\modules\v1\models\forms\ProductUpdateForm;
use Yii;

/**
 * This is the model class for table "product_packaging".
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $base_packaging Asosiy o'ram
 * @property string|null $billing_packaging Billing uchun o'ram
 * @property string|null $report_packaging Hisobot uchun o'ram
 *
 * @property Product $product
 */
class ProductPackaging extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_packaging';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id'], 'default', 'value' => null],
            [['product_id'], 'integer'],
            [['base_packaging', 'billing_packaging', 'report_packaging'], 'string', 'max' => 100],
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
            'product_id' => 'Product ID',
            'base_packaging' => 'Base Packaging',
            'billing_packaging' => 'Billing Packaging',
            'report_packaging' => 'Report Packaging',
        ];
    }


    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function find()
    {
        return new \common\models\query\ProductPackagingQuery(get_called_class());
    }

    public function create(?BaseProductModel $form): ?ProductPackaging
    {
        return $this->mapFormToModel($form, new self());
    }

    public function editData(?BaseProductModel $form): void
    {
        $this->mapFormToModel($form, new self());
    }

    protected function mapFormToModel(?BaseProductModel $form, ?ProductPackaging $model): ?ProductPackaging
    {
        $model->product_id = $form->id;
        $model->base_packaging = $form->base_packaging;
        $model->billing_packaging = $form->billing_packaging;
        $model->report_packaging = $form->report_packaging;

        return $model;
    }
}
