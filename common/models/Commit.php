<?php

namespace common\models;

use common\attributes\Repository;
use common\repositories\CommitRepository;

/**
 * This is the model class for table "commit".
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $address
 */
#[Repository(CommitRepository::class)]
class Commit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'address'], 'required'],
            [['full_name', 'email', 'phone', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CommitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CommitQuery(get_called_class());
    }
}
