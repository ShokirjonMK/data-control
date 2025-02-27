<?php

namespace common\base\search;

use common\base\search\interfaces\SortInterface;
use yii\db\ActiveQuery;

class DefaultSort implements SortInterface
{
    public function apply(ActiveQuery $query, string $sortVal): void
    {
        if ($sortVal) {
            $sortDirection = (str_starts_with($sortVal, '-')) ? SORT_DESC : SORT_ASC;
            $sortField = ltrim($sortVal, '-');

            $query->orderBy([$sortField => $sortDirection]);
        }
    }
}