<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\forms\ProductCreateForm;
use api\modules\v1\models\forms\ProductStatusCustomerForm;
use api\modules\v1\models\forms\ProductStatusWmsForm;
use api\modules\v1\models\forms\ProductUpdateForm;
use api\modules\v1\resources\Product;
use common\enum\ResponseMessageEnum;
use common\models\Product as ProductAlias;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use common\components\DeletedModel;
use Yii;
use api\modules\v1\controllers\AbstractController;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends AbstractController
{
    protected function resolveModelClass(): ?string
    {
        return Product::class;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'ids' => ['post'],
                'status' => ['post'],
            ]
        ];

        return $behaviors;
    }


    /**
     * @SWG\Get(
     *     path="/v1/product/index",
     *     tags={"Product"},
     *     summary="Get the collection of Products.",
     *     description="Returns the list of Products.",
     *     @SWG\Parameter(
     *             name="id",
     *             in="query",
     *             description="Products ID",
     *             required=false,
     *             type="integer",
     *             default=""
     *     ),
     *    @SWG\Parameter(
     *           name="page",
     *           in="query",
     *           description="Pagination page number",
     *           required=false,
     *           type="integer",
     *           default="1"
     *    ),
     *    @SWG\Parameter(
     *           name="per-page",
     *           in="query",
     *           description="Items per page for pagination",
     *           required=false,
     *           type="integer",
     *           default="20"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Product collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Product")
     *         )
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionIndex()
    {
        $data = $this->repository->findAll();

        return $this->response(1, 'Data successfully retrieved.', $data->getData());
    }


    /**
     * @SWG\Get(
     *     path="/v1/product/clients",
     *     tags={"Product"},
     *     summary="Get the collection of Products.",
     *     description="Returns the list of Products.",
     *     @SWG\Parameter(
     *             name="id",
     *             in="query",
     *             description="Products ID",
     *             required=false,
     *             type="integer",
     *             default=""
     *     ),
     *    @SWG\Parameter(
     *           name="page",
     *           in="query",
     *           description="Pagination page number",
     *           required=false,
     *           type="integer",
     *           default="1"
     *    ),
     *    @SWG\Parameter(
     *           name="per-page",
     *           in="query",
     *           description="Items per page for pagination",
     *           required=false,
     *           type="integer",
     *           default="20"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Product collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Product")
     *         )
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionClients()
    {
        $data = $this->repository->ClientFindAll();

        return $this->response(1, 'Data successfully retrieved.', $data->getData());
    }

    /**
     * @SWG\Post(
     *     path="/v1/product/create",
     *     tags={"Product"},
     *     summary="Create a new Product.",
     *     description="Creates a new Product using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Product")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Product successfully created",
     *         @SWG\Schema(ref="#/definitions/Product")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad request - validation error"
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Server error"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws \Exception
     */
    public function actionCreate()
    {
        $modelForm = new ProductCreateForm();

        if ($this->load($modelForm)) {
            $modelForm->createData();
            return $this->response(1, 'Record successfully created.', Product::findOne($modelForm->id), null, 201);
        }

        return $this->response(1, 'error.', null, $modelForm->errors, 500);

    }


    /**
     * @SWG\Post(
     *     path="/v1/product/status",
     *     tags={"Product"},
     *     summary="Create a new Product.",
     *     description="Creates a new Product using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     * @SWG\Parameter(
     *     name="body",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              property="status",
     *              type="array",
     *             @SWG\Items(
     *                  type="object",
     *                  @SWG\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @SWG\Property(
     *                      property="status",
     *                      type="string"
     *                  )
     *              )
     *          )
     *      )
     * ),
     *   @SWG\Response(
     *         response=201,
     *         description="Product successfully created",
     *         @SWG\Schema(ref="#/definitions/Product")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Server error"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws \Exception
     */
    public function actionStatus()
    {
        $modelForm = new ProductStatusWmsForm;

        if ($this->load($modelForm)) {
            $modelForm->editData();
            return $this->response(1, ResponseMessageEnum::ProductStatus->value, null, null);
        }

        return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 500);
    }

    /**
     * @SWG\Post(
     *     path="/v1/product/client-status",
     *     tags={"Product"},
     *     summary="customer status Product.",
     *     description="customer status Product using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     * @SWG\Parameter(
     *     name="body",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              property="status",
     *              type="array",
     *             @SWG\Items(
     *                  type="object",
     *                  @SWG\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @SWG\Property(
     *                      property="status",
     *                      type="string"
     *                  )
     *              )
     *          )
     *      )
     * ),
     *   @SWG\Response(
     *         response=201,
     *         description="customer status successfully created",
     *         @SWG\Schema(ref="#/definitions/Product")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Server error"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws \Exception
     */
    public function actionClientStatus()
    {
        $modelForm = new ProductStatusCustomerForm;

        if ($this->load($modelForm)) {
            $modelForm->editData();
            return $this->response(1, ResponseMessageEnum::ProductStatus->value, null, null);
        }

        return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 500);
    }


    /**
     * @SWG\Get(
     *     path="/v1/product/view",
     *     tags={"Product"},
     *     summary="Get a Product by ID.",
     *     description="Returns a single Product identified by its ID.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Product ID"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Product details",
     *         @SWG\Schema(ref="#/definitions/Product")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionView($id)
    {
        $model = $this->repository->findById($id);

        return $this->response(1, 'Record successfully retrieved.', $model, null, 200);
    }

    /**
     * @SWG\Put(
     *     path="/v1/product/update",
     *     tags={"Product"},
     *     summary="Update an existing Product.",
     *     description="Updates an existing Product using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Product ID"
     *     ),
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Product")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Product successfully updated",
     *         @SWG\Schema(ref="#/definitions/Product")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad request - validation error"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Server error"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionUpdate($id)
    {
        $model = $this->repository->findById($id);
        $modelForm = new ProductUpdateForm($model);

        if ($this->load($modelForm)) {
            $modelForm->updateData();
            return $this->response(1, 'Record successfully updated.', $model, null, 200);
        }

        throw new ServerErrorHttpException('Failed to update the Product. Please try again.');
    }

    /**
     * @SWG\Delete(
     *     path="/v1/product/delete",
     *     tags={"Product"},
     *     summary="Delete a Product by ID.",
     *     description="Deletes the specified Product.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Product ID"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Product successfully deleted"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->repository->delete($id);

        return $this->response(1, 'Record successfully deleted.', null, null, 204);
    }
}
