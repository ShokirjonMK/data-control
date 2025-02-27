<?php declare(strict_types=1);

namespace common\base\search\interfaces;

use yii\db\ActiveQuery;

interface DataProviderInterface
{
    public function getData(ActiveQuery $query, int $perPage, bool $validatePage);

}