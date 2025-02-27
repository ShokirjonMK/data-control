<?php declare(strict_types=1);

namespace common\services;

use Firebase\JWT\JWT;
use Yii;

class TokenManager
{
    private $privateKey;
    private $passphrase;

    public function __construct()
    {
        $this->privateKey = file_get_contents(Yii::getAlias(env('JWT_SECRET_KEY')));
        $this->passphrase = env('JWT_PASSPHRASE');
    }

    private function getPrivateKey()
    {
        static $privateKey = null;

        if ($privateKey === null) {
            $privateKey = openssl_pkey_get_private($this->privateKey, $this->passphrase);
        }

        return $privateKey;
    }

    public function generateAccessToken(int $userId): string
    {
        $payload = [
            'uid' => $userId,
            'iat' => time(),
            'exp' => time() + 86400,
        ];

       return JWT::encode($payload, $this->getPrivateKey(), 'RS256');
    }

    public function generateRefreshToken(int $userId): string
    {
        $payload = [
            'uid' => $userId,
            'iat' => time(),
            'exp' => time() + (86400 * 30),
        ];

        return JWT::encode($payload, $this->getPrivateKey(), 'RS256');
    }

}
