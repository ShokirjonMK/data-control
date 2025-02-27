<?php declare(strict_types=1);

namespace api\modules\v1\search;

use common\base\search\interfaces\QueryCollectionExtensionInterface;
use common\models\SupplierBuyer;
use yii\db\ActiveQuery;

class SupplierBuyerWmsSearch implements QueryCollectionExtensionInterface
{
    public function applyToCollection(ActiveQuery $query, ?array $params = []): void
    {
        $query->andWhere(['status' => SupplierBuyer::STATUS_NEW]);
    }
}