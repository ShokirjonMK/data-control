<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseProductModel;
use api\modules\v1\models\forms\ProductCreateForm;
use api\modules\v1\models\forms\ProductUpdateForm;
use Yii;

/**
 * This is the model class for table "product_technical".
 *
 * @property int $id
 * @property int $product_id
 * @property float|null $weight Og'irlik
 * @property float|null $net_weight Og'irlik (netto)
 * @property float|null $volume Hajm
 * @property float|null $net_volume Hajm (netto)
 * @property bool $is_set To'plam (Komplekt)
 * @property string $kis_code KIS kodi
 * @property string|null $default_status Holat
 *
 * @property Product $product
 */
class ProductTechnical extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_technical';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'kis_code'], 'required'],
            [['product_id'], 'default', 'value' => null],
            [['product_id'], 'integer'],
            [['weight', 'net_weight', 'volume', 'net_volume'], 'number'],
            [['is_set'], 'boolean'],
            [['kis_code'], 'string', 'max' => 50],
            [['default_status'], 'string', 'max' => 100],
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
            'weight' => 'Weight',
            'net_weight' => 'Net Weight',
            'volume' => 'Volume',
            'net_volume' => 'Net Volume',
            'is_set' => 'Is Set',
            'kis_code' => 'Kis Code',
            'default_status' => 'Default Status',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function find()
    {
        return new \common\models\query\ProductTechnicalQuery(get_called_class());
    }

    public function create(?BaseProductModel $form): ?ProductTechnical
    {
        return $this->mapFormToModel($form, new self());
    }

    public function editData(?BaseProductModel $form): void
    {
        $this->mapFormToModel($form, $this);
    }

    protected function mapFormToModel(?BaseProductModel $form, ?ProductTechnical $model): ?ProductTechnical
    {
        $model->product_id = $form->id;
        $model->weight = $form->weight;
        $model->net_weight = $form->net_weight;
        $model->volume = $form->volume;
        $model->net_volume = $form->net_volume;
        $model->is_set = $form->is_set;
        $model->kis_code = $form->kis_code;
        $model->default_status = $form->default_status;

        return $model;
    }
}
