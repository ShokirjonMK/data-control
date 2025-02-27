<?php

namespace api\modules\v1\jobs;

use common\models\Product;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class SendProductJob extends BaseObject implements JobInterface
{
    public array $productIds;

    public function execute($queue): void
    {
        if ($this->productIds) {
            Product::updateAll(['status' => Product::STATUS_DELIVERED], ['id' => $this->productIds]);
        } else {
            throw new \Exception("Failed to send product: ID " . implode(', ', $this->productIds));
        }
    }

}