<?php declare(strict_types=1);

namespace common\services;

use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;
use yii\httpclient\Response;

class WebhookService
{
    private ?Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function sendWebhook($webhookUrl, $payload): Response
    {
        $response = $this->client->createRequest()
            ->setMethod('POST')
            ->setUrl($webhookUrl)
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                ])
            ->setData($payload)
            ->send();

        if (!$response->isOk) {
            throw new Exception("Webhook muvaffaqiyatsiz: " . $response->content);
        }

        return $response;
    }

}
