<?php

namespace common\jobs;

use common\models\Commit;
use Exception;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class ProductJob extends BaseObject implements JobInterface
{

    public $product;

    public function execute($queue)
    {
        $this->commitSave();
        echo "Sent product to RabbitMQ: " . $this->product . PHP_EOL;
    }

    public function commitSave()
    {
        $commit = new Commit();
        $commit->full_name = 'dasdasd';
        $commit->email = 'dasdasdasd';
        $commit->save();
    }


}