<?php

namespace common\services;

use yii\httpclient\Client;
use yii\base\Component;
use Yii;

class RecaptchaService extends Component
{
    private Client $httpclient;

    public function __construct(Client $httpclient, $config = [])
    {
        $this->httpclient = $httpclient;
        parent::__construct($config);
    }

    public function verify($recaptchaResponse): bool
    {
        $recaptchaSecret = Yii::$app->params['recaptcha']['secretKey'];

        $response = $this->httpclient->createRequest()
            ->setMethod('POST')
            ->setUrl('https://www.google.com/recaptcha/api/siteverify')
            ->setData([
                'secret' => $recaptchaSecret,
                'response' => $recaptchaResponse,
            ])
            ->send();

        return $response->isOk && $response->data['success'] && $response->data['score'] > 0.5;
    }
}
