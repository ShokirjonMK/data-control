<?php declare(strict_types=1);

namespace common\repositories;

use api\modules\v1\resources\Product;
use api\modules\v1\search\ProductCustomerSearch;
use api\modules\v1\search\ProductWmsSearch;
use common\base\BaseFilter;
use common\base\search\DefaultFilter;
use common\components\DeletedModel;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ProductRepository
{
   private Product $product;

   public function __construct()
   {
       $this->product = new Product();
   }

    /**
     * @throws NotFoundHttpException
     */
    public function findById(int $id): array|\common\models\Product|null
    {
        if (($model = $this->product->find()->findById($id)->onlyActive()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Product not found.');
    }

    /**
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function delete(int $id): bool
    {
        $model = $this->findById($id);
        if (DeletedModel::mark($model) === false) {
            throw new ServerErrorHttpException('Failed to delete the Product. Please try again.');
        }
        return true;
    }

    public function findAll(): BaseFilter
    {
        return new BaseFilter(
            model: $this->product,
            query: $this->product->find()->onlyActive(),
            filter: new DefaultFilter,
            queryCollectionExtension: new ProductWmsSearch
        );
    }

    public function ClientFindAll(): BaseFilter
    {
        return new BaseFilter(
            model: $this->product,
            query: $this->product->find()->onlyActive(),
            filter: new DefaultFilter,
            queryCollectionExtension: new ProductCustomerSearch
        );
    }
}