<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rate_limit".
 *
 * @property int $id
 * @property string|null $ip
 * @property int|null $user_id
 * @property int|null $rate_limit
 * @property int|null $time_period
 * @property int|null $request_count
 * @property int|null $type
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class RateLimit extends \yii\db\ActiveRecord
{
    const isGuest = 1;
    const isApi = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rate_limit';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    public function getTypeLabel(): string
    {
        return $this->type === self::isApi ? 'Guest' : 'User';
    }

    public static function getTypeOptions(): array
    {
        return [
            self::isApi => 'Guest',
            self::isGuest => 'User',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['type', 'unique', 'targetClass' => self::class, 'message' => 'This type has already been set.'],
            [['user_id', 'rate_limit', 'time_period', 'request_count', 'type', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'rate_limit', 'time_period', 'request_count', 'type', 'created_at', 'updated_at'], 'integer'],
            [['ip'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'user_id' => 'User ID',
            'rate_limit' => 'Rate Limit',
            'time_period' => 'Time Period',
            'request_count' => 'Request Count',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\RateLimitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\RateLimitQuery(get_called_class());
    }
}
