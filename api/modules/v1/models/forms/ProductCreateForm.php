<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseProductModel;
use common\models\Product;
use common\models\ProductPackaging;
use common\models\ProductShelfLife;
use common\models\ProductTechnical;
use Exception;

class ProductCreateForm extends BaseProductModel
{
    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function createData(): void
    {

        executeTransaction(function () {

            $product = (new Product)->create($this);
            saveModel($product, 'product');

            $this->id = $product->id;

            $productTechnical = (new ProductTechnical)->create($this);
            saveModel($productTechnical, 'productTechnical');

            $productShelfLife = (new ProductShelfLife)->create($this);
            saveModel($productShelfLife, 'productShelfLife');

            $productPackaging = (new ProductPackaging)->create($this);
            saveModel($productPackaging, 'productPackaging');

        });
    }
}
