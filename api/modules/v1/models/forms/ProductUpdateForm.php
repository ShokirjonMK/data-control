<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseProductModel;
use common\models\Product;
use Exception;

class ProductUpdateForm extends BaseProductModel
{

    public function __construct(private readonly Product $product, $config = [])
    {
        $this->id = $product->id;
        parent::__construct($config);
    }

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function updateData(): void
    {
        executeTransaction(function () {

            $this->product->editData($this);
            updateModel($this->product, 'product');

            $this->product->productTechnical->editData($this);
            updateModel($this->product->productTechnical, 'productTechnical');

            $this->product->productShelfLive->editData($this);
            updateModel($this->product->productShelfLive, 'productShelfLive');

            $this->product->productPackagin->editData($this);
            updateModel($this->product->productPackagin, 'productPackaging');

        });
    }
}
