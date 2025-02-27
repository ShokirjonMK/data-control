<?php declare(strict_types=1);

namespace api\modules\v1\resources;

use common\attributes\Repository;
use common\repositories\ProductRepository;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

#[Repository(ProductRepository::class)]
class Product extends \common\models\Product implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'supplier_buyer_id',
            'group',
            'code',
            'name',
            'full_name',
            'gtin',
            'article',
            'nomenclature_type',
            'unit',
            'comment',
            'productPackagin',
            'productShelfLive',
            'productTechnical'
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['product/view', 'id' => $this->id], true)
        ];
    }
}
