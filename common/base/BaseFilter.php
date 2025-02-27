<?php declare(strict_types=1);

namespace common\base;

use common\base\search\DefaultDataProvider;
use common\base\search\interfaces\FilterInterface;
use common\base\search\interfaces\QueryCollectionExtensionInterface;
use common\base\search\interfaces\SortInterface;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class BaseFilter
{
    private DefaultDataProvider $dataProvider;

    public function     __construct(
        private ActiveRecord                       $model,
        private ActiveQuery                        $query,
        private ?FilterInterface                   $filter = null,
        private ?SortInterface                     $sort = null,
        private ?QueryCollectionExtensionInterface $queryCollectionExtension = null
    )
    {
        $this->dataProvider = new DefaultDataProvider;
    }

    public function getData(?array $params = []): ?array
    {
        $this->queryCollectionExtension?->applyToCollection($this->query, $params);

        $this->filter?->apply($this->query, $this->model);

        $this->sort?->apply($this->query, Yii::$app->request->get('sort', ''));

        return $this->dataProvider->getData($this->query, 20, true);
    }
}