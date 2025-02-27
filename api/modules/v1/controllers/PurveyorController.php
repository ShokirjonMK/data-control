<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\forms\ProductStatusCustomerForm;
use api\modules\v1\models\forms\SupplierBuyerCreateForm;
use api\modules\v1\models\forms\SupplierBuyerStatusCustomerForm;
use api\modules\v1\models\forms\SupplierBuyerStatusWmsForm;
use api\modules\v1\models\forms\SupplierBuyerUpdateForm;
use api\modules\v1\resources\SupplierBuyer;
use api\modules\v1\search\SupplierBuyerCustomerSearch;
use api\modules\v1\search\SupplierBuyerWmsSearch;
use common\base\BaseFilter;
use common\base\search\DefaultDataProvider;
use common\base\search\DefaultFilter;
use common\components\DeletedModel;
use common\enum\ResponseMessageEnum;
use Yii;
use api\modules\v1\controllers\AbstractController;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * PurveyorController implements the CRUD actions for Purveyor model.
 */
class PurveyorController extends AbstractController
{

    /**
     * @SWG\Get(
     *     path="/v1/purveyor/index",
     *     tags={"Purveyor"},
     *     summary="Get the collection of Purveyor.",
     *     description="Returns the list of Purveyor.",
     *     @SWG\Parameter(
     *             name="id",
     *             in="query",
     *             description="Purveyor ID",
     *             required=false,
     *             type="integer",
     *             default="1"
     *    ),
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
     *         description="Purveyor collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Purveyor")
     *         )
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionIndex(): ?array
    {
        $model = new SupplierBuyer();
        
        $data = new BaseFilter(
            model: $model, 
            query: $model->find()->onlyActive(),
            filter: new DefaultFilter,
            queryCollectionExtension: new SupplierBuyerWmsSearch
        );

        return $this->response(1, 'Data successfully retrieved.', $data->getData());
    }

    /**
     * @SWG\Get(
     *     path="/v1/purveyor/clients",
     *     tags={"Purveyor"},
     *     summary="Get the collection of Purveyor.",
     *     description="Returns the list of Purveyor.",
     *     @SWG\Parameter(
     *             name="id",
     *             in="query",
     *             description="Purveyor ID",
     *             required=false,
     *             type="integer",
     *             default="1"
     *    ),
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
     *         description="Purveyor collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Purveyor")
     *         )
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionClients(): ?array
    {
        $model = new SupplierBuyer();

        $data = new BaseFilter(
            model: $model,
            query: $model->find()->onlyActive(),
            filter: new DefaultFilter,
            queryCollectionExtension: new SupplierBuyerCustomerSearch
        );

        return $this->response(1, 'Data successfully retrieved.', $data->getData());
    }

    /**
     * @SWG\Post(
     *     path="/v1/purveyor/create",
     *     tags={"Purveyor"},
     *     summary="Create a new Purveyor.",
     *     description="Creates a new Purveyor using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Purveyor")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Purveyor successfully created",
     *         @SWG\Schema(ref="#/definitions/Purveyor")
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
    public function actionCreate(): ?array
    {
        $modelForm = new SupplierBuyerCreateForm();

        if ($this->load($modelForm)) {
            $modelForm->createData();
            return $this->response(1, 'Record successfully created.', SupplierBuyer::findOne($modelForm->id), null, 201);
        }

        return $this->response(1, 'error.', null, $modelForm->errors, 500);
    }

    /**
     * @SWG\Post(
     *     path="/v1/purveyor/status",
     *     tags={"Purveyor"},
     *     summary="customer status Purveyor.",
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
    public function actionStatus()
    {
        $modelForm = new SupplierBuyerStatusWmsForm;

        if ($this->load($modelForm)) {
            $modelForm->editData();
            return $this->response(1, ResponseMessageEnum::ProductStatus->value, null, null);
        }

        return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 500);
    }

    /**
     * @SWG\Post(
     *     path="/v1/purveyor/client-status",
     *     tags={"Purveyor"},
     *     summary="customer status Purveyor.",
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
        $modelForm = new SupplierBuyerStatusCustomerForm;

        if ($this->load($modelForm)) {
            $modelForm->editData();
            return $this->response(1, ResponseMessageEnum::ProductStatus->value, null, null);
        }

        return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 500);
    }

    /**
     * @SWG\Get(
     *     path="/v1/purveyor/view",
     *     tags={"Purveyor"},
     *     summary="Get a Purveyor by ID.",
     *     description="Returns a single Purveyor identified by its ID.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Purveyor ID"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Purveyor details",
     *         @SWG\Schema(ref="#/definitions/Purveyor")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Purveyor not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws NotFoundHttpException
     */
    public function actionView($id): ?array
    {
        $model = $this->findModel($id);
        
        return $this->response(1, 'Record successfully retrieved.', $model, null, 200);
    }

    /**
     * @SWG\Put(
     *     path="/v1/purveyor/update",
     *     tags={"Purveyor"},
     *     summary="Update an existing Purveyor.",
     *     description="Updates an existing Purveyor using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Purveyor ID"
     *     ),
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Purveyor")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Purveyor successfully updated",
     *         @SWG\Schema(ref="#/definitions/Purveyor")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad request - validation error"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Purveyor not found"
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Server error"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws \Exception
     */
    public function actionUpdate($id): ?array
    {
        $model = $this->findModel($id);

        $modelForm = new SupplierBuyerUpdateForm($model);

        if ($this->load($modelForm)) {
            $modelForm->updateData();
            return $this->response(1, 'Record successfully updated.', $model, null, 200);
            
        }

        return $this->response(1, 'error.', null, $modelForm->errors, 500);
    }

    /**
     * @SWG\Delete(
     *     path="/v1/purveyor/delete",
     *     tags={"Purveyor"},
     *     summary="Delete a Purveyor by ID.",
     *     description="Deletes the specified Purveyor.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Purveyor ID"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Purveyor successfully deleted"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Purveyor not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (DeletedModel::mark($model) === false) {
            throw new ServerErrorHttpException('Failed to delete the Purveyor. Please try again.');
        }
    
       return $this->response(1, 'Record successfully deleted.', null, null, 204);

    }


    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id): \common\models\SupplierBuyer|array|null
    {
        if (($model = SupplierBuyer::find()->andWhere(['id' => $id])->onlyActive()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Purveyor not found.');
    }
}
