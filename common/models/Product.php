<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseProductModel;
use api\modules\v1\models\forms\ProductCreateForm;
use api\modules\v1\models\forms\ProductUpdateForm;
use common\models\query\ProductQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $supplier_buyer_id
 * @property string $group Mahsulot guruhi
 * @property string $code Mahsulot kodi
 * @property string $name Mahsulot nomi
 * @property string $full_name Mahsulotning to'liq nomi
 * @property string|null $gtin GTIN (Global Trade Item Number)
 * @property string $article Mahsulotning artikul raqami
 * @property string $nomenclature_type Nomenklatura turi
 * @property string $unit O'lchov birligi
 * @property string|null $comment Izoh
 * @property int $status
 * @property int $customer_status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property ProductPackaging $productPackagin
 * @property ProductShelfLife $productShelfLive
 * @property ProductTechnical $productTechnical
 * @property SupplierBuyer $supplierBuyer
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_APPROVED = 2;
    const STATUS_DELIVERED = 0;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
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
            [['group', 'code', 'name', 'full_name', 'article', 'nomenclature_type', 'unit'], 'required'],
            [['supplier_buyer_id', 'status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['supplier_buyer_id', 'status', 'customer_status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['comment'], 'string'],
            [['group', 'name', 'full_name'], 'string', 'max' => 255],
            [['code', 'article', 'nomenclature_type'], 'string', 'max' => 100],
            [['gtin', 'unit'], 'string', 'max' => 50],
            [['code'], 'unique'],
            [['gtin'], 'unique'],
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
            'group' => 'Group',
            'code' => 'Code',
            'name' => 'Name',
            'full_name' => 'Full Name',
            'gtin' => 'Gtin',
            'article' => 'Article',
            'nomenclature_type' => 'Nomenclature Type',
            'unit' => 'Unit',
            'comment' => 'Comment',
            'customer_status' => 'Customer Status',

            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }


    public function getProductPackagin()
    {
        return $this->hasOne(ProductPackaging::class, ['product_id' => 'id']);
    }


    public function getProductShelfLive()
    {
        return $this->hasOne(ProductShelfLife::class, ['product_id' => 'id']);
    }


    public function getProductTechnical()
    {
        return $this->hasOne(ProductTechnical::class, ['product_id' => 'id']);
    }

    public function getSupplierBuyer()
    {
        return $this->hasOne(SupplierBuyer::class, ['id' => 'supplier_buyer_id']);
    }

    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public function create(?BaseProductModel $form): ?Product
    {
        return $this->mapFormToModel($form, new self());
    }

    public function editData(?BaseProductModel $form): void
    {
        $this->mapFormToModel($form, $this);
    }

    protected function mapFormToModel(BaseProductModel $form, Product $model): Product
    {
        $model->group = $form->group;
        $model->code = $form->code;
        $model->name = $form->name;
        $model->full_name = $form->full_name;
        $model->article = $form->article;
        $model->nomenclature_type = $form->nomenclature_type;
        $model->unit = $form->unit;
        $model->gtin = $form->gtin;
        $model->comment = $form->comment;
        $model->status = self::STATUS_NEW;
        $model->supplier_buyer_id = $form->supplier_buyer_id;

        return $model;
    }
}
