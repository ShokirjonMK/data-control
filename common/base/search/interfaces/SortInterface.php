<?php declare(strict_types=1);

namespace common\base\search\interfaces;

use yii\db\ActiveQuery;

interface SortInterface
{
    public function apply(ActiveQuery $query, string $sortVal): void;

}