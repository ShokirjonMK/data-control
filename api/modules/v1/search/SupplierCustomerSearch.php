<?php declare(strict_types=1);

namespace api\modules\v1\search;

use common\base\search\interfaces\QueryCollectionExtensionInterface;
use common\models\Supplier;
use yii\db\ActiveQuery;

class SupplierCustomerSearch implements QueryCollectionExtensionInterface
{
    public function applyToCollection(ActiveQuery $query, ?array $params = []): void
    {
        $query->andWhere(['status' => Supplier::STATUS_NEW]);
    }
}