<?php declare(strict_types=1);

namespace common\base\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class DefaultDataProvider
{
    public function getData(ActiveQuery $query, int $perPage, bool $validatePage): ?array
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page') ?? $perPage,
                'validatePage' => $validatePage,
            ],
        ]);

        return [
            'items' => $dataProvider->getModels(),
            '_links' => $dataProvider->pagination->getLinks(),
            '_meta' => [
                'totalCount' => $dataProvider->pagination->totalCount,
                'pageCount' => $dataProvider->pagination->pageCount,
                'currentPage' => $dataProvider->pagination->page + 1,
                'perPage' => $dataProvider->pagination->pageSize,
            ],
        ];
    }
}