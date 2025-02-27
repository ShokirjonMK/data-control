<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\forms\SupplierBuyerStatusCustomerForm;
use api\modules\v1\models\forms\SupplierCreateForm;
use api\modules\v1\models\forms\SupplierStatusCustomerForm;
use api\modules\v1\models\forms\SupplierStatusWmsForm;
use api\modules\v1\models\forms\SupplierUpdateForm;
use api\modules\v1\resources\Supplier;
use api\modules\v1\search\SupplierCustomerSearch;
use api\modules\v1\search\SupplierWmsSearch;
use common\base\BaseFilter;
use common\base\search\DefaultDataProvider;
use common\base\search\DefaultFilter;
use common\enum\ResponseMessageEnum;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use common\components\DeletedModel;
use Yii;
use api\modules\v1\controllers\AbstractController;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

/**
 * ReceivingGoodsController implements the CRUD actions for ReceivingGoods model.
 */
class ReceivingGoodsController extends AbstractController
{

    /**
     * @SWG\Get(
     *     path="/v1/receiving-goods/index",
     *     tags={"ReceivingGoods"},
     *     summary="Get the collection of ReceivingGoods.",
     *     description="Returns the list of ReceivingGoods.",
     *     @SWG\Parameter(
     *             name="id",
     *             in="query",
     *             description="ReceivingGoods ID",
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
     *         description="ReceivingGoods collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/ReceivingGoods")
     *         )
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionIndex()
    {
        $model = new Supplier();
        
        $data = new BaseFilter(
            model: $model, 
            query: $model->find()->onlyActive(),
            filter: new DefaultFilter,
            queryCollectionExtension: new SupplierWmsSearch
        );

        return $this->response(1, 'Data successfully retrieved.', $data->getData());
    }

    /**
     * @SWG\Get(
     *     path="/v1/receiving-goods/clients",
     *     tags={"ReceivingGoods"},
     *     summary="Get the collection of ReceivingGoods.",
     *     description="Returns the list of ReceivingGoods.",
     *     @SWG\Parameter(
     *             name="id",
     *             in="query",
     *             description="ReceivingGoods ID",
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
     *         description="ReceivingGoods collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/ReceivingGoods")
     *         )
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionClients()
    {
        $model = new Supplier();

        $data = new BaseFilter(
            model: $model,
            query: $model->find()->onlyActive(),
            filter: new DefaultFilter,
            queryCollectionExtension: new SupplierCustomerSearch
        );

        return $this->response(1, 'Data successfully retrieved.', $data->getData());
    }

    /**
     * @SWG\Post(
     *     path="/v1/receiving-goods/create",
     *     tags={"ReceivingGoods"},
     *     summary="Create a new ReceivingGoods.",
     *     description="Creates a new ReceivingGoods using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/ReceivingGoods")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="ReceivingGoods successfully created",
     *         @SWG\Schema(ref="#/definitions/ReceivingGoods")
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
     */
    public function actionCreate()
    {
        $modelForm = new SupplierCreateForm();

        if ($this->load($modelForm)) {
            $modelForm->createData();
            return $this->response(1, 'Record successfully created.', Supplier::findOne($modelForm->id), null, 201);
        }

        return $this->response(1, 'error.', null, $modelForm->errors, 500);

    }

    /**
     * @SWG\Post(
     *     path="/v1/receiving-goods/status",
     *     tags={"ReceivingGoods"},
     *     summary="customer status ReceivingGoods.",
     *     description="customer status ReceivingGoods using the provided data.",
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
    public function actionStatus()
    {
        $modelForm = new SupplierStatusWmsForm;

        if ($this->load($modelForm)) {
            $modelForm->editData();
            return $this->response(1, ResponseMessageEnum::ProductStatus->value, null, null);
        }

        return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 500);
    }

    /**
     * @SWG\Post(
     *     path="/v1/receiving-goods/client-status",
     *     tags={"ReceivingGoods"},
     *     summary="client status ReceivingGoods.",
     *     description="customer status ReceivingGoods using the provided data.",
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
        $modelForm = new SupplierStatusCustomerForm;

        if ($this->load($modelForm)) {
            $modelForm->editData();
            return $this->response(1, ResponseMessageEnum::ProductStatus->value, null, null);
        }

        return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 500);
    }

    /**
     * @SWG\Get(
     *     path="/v1/receiving-goods/view",
     *     tags={"ReceivingGoods"},
     *     summary="Get a ReceivingGoods by ID.",
     *     description="Returns a single ReceivingGoods identified by its ID.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="ReceivingGoods ID"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="ReceivingGoods details",
     *         @SWG\Schema(ref="#/definitions/ReceivingGoods")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="ReceivingGoods not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
    
        return $this->response(1, 'Record successfully retrieved.', $model, null, 200);
    }

    /**
     * @SWG\Put(
     *     path="/v1/receiving-goods/update",
     *     tags={"ReceivingGoods"},
     *     summary="Update an existing ReceivingGoods.",
     *     description="Updates an existing ReceivingGoods using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="ReceivingGoods ID"
     *     ),
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/ReceivingGoods")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="ReceivingGoods successfully updated",
     *         @SWG\Schema(ref="#/definitions/ReceivingGoods")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad request - validation error"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="ReceivingGoods not found"
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
        $model = $this->findModel($id);
        $modelForm = new SupplierUpdateForm($model);

        if ($this->load($modelForm)) {
            $modelForm->updateData();
            return $this->response(1, 'Record successfully updated.', $model, null, 200);
        }

        throw new ServerErrorHttpException('Failed to update the ReceivingGoods. Please try again.');
    }

    /**
     * @SWG\Delete(
     *     path="/v1/receiving-goods/delete",
     *     tags={"ReceivingGoods"},
     *     summary="Delete a ReceivingGoods by ID.",
     *     description="Deletes the specified ReceivingGoods.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="ReceivingGoods ID"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="ReceivingGoods successfully deleted"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="ReceivingGoods not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if (DeletedModel::mark($model) === false) {
            throw new ServerErrorHttpException('Failed to delete the ReceivingGoods. Please try again.');
        }
    
       return $this->response(1, 'Record successfully deleted.', null, null, 204);


    }
    
    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id): \common\models\Supplier|array|null
    {
        if (($model = Supplier::find()->andWhere(['id' => $id])->onlyActive()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('ReceivingGoods not found.');
    }
}
