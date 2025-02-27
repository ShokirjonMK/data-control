<?php declare(strict_types=1);

namespace common\base\search\interfaces;

use yii\db\ActiveQuery;

interface QueryCollectionExtensionInterface
{
    public function applyToCollection(ActiveQuery $query, ?array $params = []);

}