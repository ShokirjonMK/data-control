<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseProductModel;
use api\modules\v1\models\forms\ProductCreateForm;
use api\modules\v1\models\forms\ProductUpdateForm;
use common\models\query\ProductShelfLifeQuery;
use Yii;

/**
 * This is the model class for table "product_shelf_life".
 *
 * @property int $id
 * @property int $product_id
 * @property float $shelf_life_stock Yaroqlilik zaxirasi
 * @property float|null $min_shelf_life_stock Minimal yaroqlilik zaxirasi
 * @property int|null $shelf_life_deviation_days Yaroqlilik muddatining chetlashishi kunlarda
 * @property int|null $shelf_life_period Yaroqlilik zaxirasi muddati
 * @property int|null $min_shelf_life_period Minimal yaroqlilik zaxirasi muddati
 * @property int|null $shelf_life_deviation_period Yaroqlilik muddatining chetlashishi muddati
 * @property int|null $storage_period_days Saqlash muddati kunlarda
 * @property string $specification Spetsifikatsiya
 * @property string $temperature_mode Harorat rejimi
 *
 * @property Product $product
 */
class ProductShelfLife extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_shelf_life';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'shelf_life_stock', 'specification', 'temperature_mode'], 'required'],
            [['product_id', 'shelf_life_deviation_days', 'shelf_life_period', 'min_shelf_life_period', 'shelf_life_deviation_period', 'storage_period_days'], 'default', 'value' => null],
            [['product_id', 'shelf_life_deviation_days', 'shelf_life_period', 'min_shelf_life_period', 'shelf_life_deviation_period', 'storage_period_days'], 'integer'],
            [['shelf_life_stock', 'min_shelf_life_stock'], 'number'],
            [['specification'], 'string'],
            [['temperature_mode'], 'string', 'max' => 100],
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
            'shelf_life_stock' => 'Shelf Life Stock',
            'min_shelf_life_stock' => 'Min Shelf Life Stock',
            'shelf_life_deviation_days' => 'Shelf Life Deviation Days',
            'shelf_life_period' => 'Shelf Life Period',
            'min_shelf_life_period' => 'Min Shelf Life Period',
            'shelf_life_deviation_period' => 'Shelf Life Deviation Period',
            'storage_period_days' => 'Storage Period Days',
            'specification' => 'Specification',
            'temperature_mode' => 'Temperature Mode',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function find()
    {
        return new ProductShelfLifeQuery(get_called_class());
    }

    public function create(?BaseProductModel $form): ProductShelfLife
    {
       return $this->mapFormToModel($form, new self());
    }

    public function editData(?BaseProductModel $form): void
    {
        $this->mapFormToModel($form, $this);
    }

    protected function mapFormToModel(?BaseProductModel $form, ?ProductShelfLife $model): ?ProductShelfLife
    {
        $model->product_id = $form->id;
        $model->shelf_life_stock = $form->shelf_life_stock;
        $model->min_shelf_life_stock = $form->min_shelf_life_stock;
        $model->shelf_life_deviation_days = $form->shelf_life_deviation_days;
        $model->shelf_life_period = $form->shelf_life_period;
        $model->min_shelf_life_period = $form->min_shelf_life_period;
        $model->shelf_life_deviation_period  = $form->shelf_life_deviation_period;
        $model->storage_period_days = $form->storage_period_days;
        $model->specification = $form->specification;
        $model->temperature_mode = $form->temperature_mode;

        return $model;
    }
}
