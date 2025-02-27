<?php

namespace api\modules\v1\services;

use Yii;
use yii\web\TooManyRequestsHttpException;

class RateLimiterService
{
    private $redis;
    private $rateLimit;
    private $timePeriod;
    private $ip;

    public function __construct($isIpAddress, $rateLimit = 50, $timePeriod = 60)
    {
        $this->redis = Yii::$app->redis;
        $this->rateLimit = $rateLimit;
        $this->timePeriod = $timePeriod;
        $this->ip = $isIpAddress;
    }

    public function checkGuestRateLimit()
    {
        $key = 'rate_limit_ip_' . $this->ip;
        $currentTime = time();
        $data = $this->redis->hmget($key, 'allowance', 'last_check');

        if ($data[0] === false || $data[1] === false) {
            $allowance = $this->rateLimit;
            $lastCheck = $currentTime;
        } else {
            $allowance = (int)$data[0];
            $lastCheck = (int)$data[1];

            $timePassed = $currentTime - $lastCheck;
            $newAllowance = $allowance + ($timePassed * ($this->rateLimit / $this->timePeriod));

            $allowance = min($this->rateLimit, $newAllowance);
            $lastCheck = $currentTime;
        }

        if ($allowance < 1) {
            throw new TooManyRequestsHttpException('Too many requests from this IP, please try again later.');
        }

        $allowance -= 1;

        $this->redis->hset($key, 'allowance', $allowance);
        $this->redis->hset($key, 'last_check', $lastCheck);
        $this->redis->expire($key, $this->timePeriod);
    }
}
