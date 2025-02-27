<?php declare(strict_types=1);

namespace api\modules\v1\search;

use common\base\search\interfaces\QueryCollectionExtensionInterface;
use common\models\Product;
use yii\db\ActiveQuery;

class ProductWmsSearch implements  QueryCollectionExtensionInterface
{
    public function applyToCollection(ActiveQuery $query, ?array $params = []): void
    {
        $query->andWhere(['status' => Product::STATUS_NEW]);
    }
}