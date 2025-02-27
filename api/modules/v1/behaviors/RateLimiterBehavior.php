<?php

namespace api\modules\v1\behaviors;

use api\modules\v1\services\RateLimiterService;
use common\models\RateLimit;
use Yii;
use yii\base\Behavior;
use yii\base\Controller as ControllerAlias;

class RateLimiterBehavior extends Behavior
{
    public function events()
    {
        return [
            ControllerAlias::EVENT_BEFORE_ACTION => 'checkRateLimit',
        ];
    }

    public function checkRateLimit()
    {
        $type = Yii::$app->user->isGuest ? RateLimit::isGuest : RateLimit::isApi;
        $rateLimitModel = RateLimit::findOne(['type' => $type]);

        $identifier = Yii::$app->user->isGuest ? Yii::$app->request->userIP : Yii::$app->user->identity->getId();
        $rateLimiter = new RateLimiterService(
            $identifier,
            $rateLimitModel->rate_limit,
            $rateLimitModel->time_period
        );

        $rateLimiter->checkGuestRateLimit();
    }
}