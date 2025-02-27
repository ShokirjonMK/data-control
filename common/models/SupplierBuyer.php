<?php

namespace common\models;

use api\modules\v1\models\forms\baseModel\BaseSupplierBuyerModel;
use api\modules\v1\models\forms\SupplierBuyerCreateForm;
use api\modules\v1\models\forms\SupplierBuyerUpdateForm;
use common\models\query\SupplierBuyerQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "supplier_buyer".
 *
 * @property int $id
 * @property string $group
 * @property string $code
 * @property string $name
 * @property string $full_name
 * @property string|null $name_eng
 * @property int $status
 * @property int $customer_status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int|null $parent_id
 *
 * @property ContractBankDetails $contractBankDetail
 * @property EntityType $entityType
 * @property SupplierBuyerStatus $supplierBuyerStatus
 * @property TaxInfo $taxInfo
 * @property User $user
 */
class SupplierBuyer extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 1;
    const STATUS_APPROVED = 2;
    const STATUS_DELIVERED = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_buyer';
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
            [['group', 'code', 'name', 'full_name'], 'required'],
            [['status', 'parent_id', 'customer_status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['group', 'name', 'full_name', 'name_eng'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group' => 'Group',
            'code' => 'Code',
            'name' => 'Name',
            'full_name' => 'Full Name',
            'name_eng' => 'Name Eng',
            'status' => 'Status',
            'parent_id' => 'Parent ID',

            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }

    public function getContractBankDetail()
    {
        return $this->hasOne(ContractBankDetails::class, ['supplier_buyer_id' => 'id']);
    }

    public function getEntityType()
    {
        return $this->hasOne(EntityType::class, ['supplier_buyer_id' => 'id']);
    }

    public function getSupplierBuyerStatus()
    {
        return $this->hasOne(SupplierBuyerStatus::class, ['supplier_buyer_id' => 'id']);
    }

    public function getTaxInfo()
    {
        return $this->hasOne(TaxInfo::class, ['supplier_buyer_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['supplier_buyer_id' => 'id']);
    }

    public static function find()
    {
        return new SupplierBuyerQuery(get_called_class());
    }

    public function create(?BaseSupplierBuyerModel $form): ?SupplierBuyer
    {
        return $this->mapFormToModel($form, new self());
    }

    public function editData(?BaseSupplierBuyerModel $form): void
    {
       $this->mapFormToModel($form, $this);
    }

    protected function mapFormToModel(?BaseSupplierBuyerModel $form, ?SupplierBuyer $model): ?SupplierBuyer
    {
        $model->group = $form->group;
        $model->code = $form->code;
        $model->name = $form->name;
        $model->full_name = $form->full_name;
        $model->name_eng = $form->name_eng;
        $this->isParent($model);
        $model->status = self::STATUS_NEW;

        return $model;
    }

    private function isParent(?SupplierBuyer $model): void
    {
        if ($model->isNewRecord && Yii::$app->user->identity->userSupplierBuyer){
            $model->parent_id = Yii::$app->user->identity->userSupplierBuyer->id;
        }
    }

}
