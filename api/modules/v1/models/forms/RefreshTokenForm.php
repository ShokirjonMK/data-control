<?php

namespace api\modules\v1\models\forms;

use api\modules\v1\resources\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Yii;
use yii\base\Model;

class RefreshTokenForm extends Model
{
    public $refresh_token;

    public function rules()
    {
        return [
            [['refresh_token'], 'required'],
            [['refresh_token'], 'string'],
        ];
    }

    public function refreshToken()
    {
        try {
            $publicKey = file_get_contents(Yii::getAlias(env('JWT_PUBLIC_KEY')));
            $decoded = JWT::decode($this->refresh_token, new Key($publicKey, 'RS256'));

            $user = User::findOne(['id' => $decoded->uid]);

            if (!$user) {
                $this->addError('refresh_token', 'Refresh token yaroqsiz');
                return null;
            }

            return $user->createAccessToken($user->id);

        } catch (\Exception $e) {
            $this->addError('refresh_token', 'Refresh token noto‘g‘ri yoki muddati o‘tgan');
            return null;
        }
    }
}
