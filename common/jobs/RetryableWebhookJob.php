<?php declare(strict_types=1);

namespace common\jobs;

use common\services\WebhookService;
use Exception;
use Yii;
use yii\base\BaseObject;
use yii\queue\RetryableJobInterface;

class RetryableWebhookJob extends BaseObject implements RetryableJobInterface
{
    public $webhookUrl;
    public $payload;

    /**
     * @throws Exception
     */
    public function execute($queue): void
    {
        $webhookService = Yii::$container->get(WebhookService::class);

        try {
            $webhookService->sendWebhook($this->webhookUrl, $this->payload);
        } catch (Exception $e) {
            throw new Exception("Error in first webhook: " . $e->getMessage());
        }
    }

    public function getTtr(): int
    {
        return 60;
    }

    public function canRetry($attempt, $error): bool
    {
        return true;
    }
}