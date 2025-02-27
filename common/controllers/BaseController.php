<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;
use yii\web\TooManyRequestsHttpException;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->request->isPost && !in_array($action->id, $this->isEnableCsrfValidation())) {
            $recaptchaResponse = Yii::$app->request->post('g-recaptcha-response');
            $recaptchaService = Yii::$app->recaptchaService;

            if (!$recaptchaService->verify($recaptchaResponse)) {
                throw new TooManyRequestsHttpException('Please verify that you are not a robot.');
            }
        }

        return parent::beforeAction($action);
    }

    public function isEnableCsrfValidation(): array
    {
        return [
            'logout',
            'delete',
            'clear-logs'
        ];
    }

}