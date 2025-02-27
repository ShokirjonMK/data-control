<?php declare(strict_types=1);

namespace common\base\search\interfaces;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

interface FilterInterface
{
    public function apply(ActiveQuery $query, ActiveRecord $model): void;

}