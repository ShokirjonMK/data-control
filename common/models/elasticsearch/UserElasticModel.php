<?php declare(strict_types=1);

namespace common\models\elasticsearch;

use common\models\User;
use common\services\TokenManager;
use Yii;
use yii\elasticsearch\ActiveRecord;

/**
 * @property $id
 * @property $username
 * @property $status
 * @property $phone
 * @property $tin_number
 * @property $password_hash
 */
class UserElasticModel extends ActiveRecord
{
    public static function index(): string
    {
        return 'user_index';
    }

    public static function type(): string
    {
        return '_doc';
    }

    public function attributes(): array
    {
        return ['id', 'username', 'status', 'phone', 'tin_number', 'password_hash'];
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public static function findByUsername($data)
    {
        return static::find()
            ->andWhere(['status' => 2])
            ->andWhere(['or', ['phone' => $data], ['tin_number' => $data]])
            ->one();
    }

    public function createUser(User $data): self
    {
        return $this->extracted($data);
    }

    public function updateUser(User $data): self
    {
        return $this->extracted($data);
    }

    public function createAccessToken($userId = null): array
    {
        if ($userId === null) {
            $userId = $this->id;
        }

        $tokenManager = new TokenManager();

        return [
            'access_token' => $tokenManager->generateAccessToken($userId),
            'refresh_token' => $tokenManager->generateRefreshToken($userId),
        ];
    }

    public function extracted(?User $data): self
    {
        $this->id = $data->id;
        $this->username = $data->username;
        $this->status = $data->status;
        $this->phone = $data->phone;
        $this->tin_number = $data->tin_number;
        $this->password_hash = $data->password_hash;

        return $this;
    }
}
