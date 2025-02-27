<?php declare(strict_types=1);

namespace api\modules\v1\search;

use common\base\search\interfaces\QueryCollectionExtensionInterface;
use common\models\SupplierBuyer;
use yii\db\ActiveQuery;

class SupplierBuyerCustomerSearch implements QueryCollectionExtensionInterface
{
    public function applyToCollection(ActiveQuery $query, ?array $params = []): void
    {
        $query->andWhere(['customer_status' => SupplierBuyer::STATUS_NEW]);
    }
}