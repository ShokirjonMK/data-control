<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\forms\OrderCreateForm;
use api\modules\v1\models\forms\OrderUpdateForm;
use api\modules\v1\resources\Order;
use common\base\BaseFilter;
use common\base\search\DefaultDataProvider;
use common\base\search\DefaultFilter;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use common\components\DeletedModel;
use Yii;
use api\modules\v1\controllers\AbstractController;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends AbstractController
{

    /**
     * @SWG\Get(
     *     path="/v1/order/index",
     *     tags={"Order"},
     *     summary="Get the collection of Orders.",
     *     description="Returns the list of Orders.",
     *     @SWG\Parameter(
     *             name="id",
     *             in="query",
     *             description="Orders ID",
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
     *         description="Order collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Order")
     *         )
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionIndex()
    {
        $model = new Order();
        
        $data = new BaseFilter(
            model: $model, 
            query: $model->find()->onlyActive(),
            filter: new DefaultFilter
        );

        return $this->response(1, 'Data successfully retrieved.', $data->getData());
    }

    /**
     * @SWG\Post(
     *     path="/v1/order/create",
     *     tags={"Order"},
     *     summary="Create a new Order.",
     *     description="Creates a new Order using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Order")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Order successfully created",
     *         @SWG\Schema(ref="#/definitions/Order")
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
        $modelForm = new OrderCreateForm();

        if ($this->load($modelForm)) {
            $modelForm->createData();
            return $this->response(1, 'Record successfully created.', Order::findOne($modelForm->id), null, 201);
        }

        return $this->response(1, 'error.', null, $modelForm->errors, 500);

    }

    /**
     * @SWG\Get(
     *     path="/v1/order/view",
     *     tags={"Order"},
     *     summary="Get a Order by ID.",
     *     description="Returns a single Order identified by its ID.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Order ID"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Order details",
     *         @SWG\Schema(ref="#/definitions/Order")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Order not found"
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
     *     path="/v1/order/update",
     *     tags={"Order"},
     *     summary="Update an existing Order.",
     *     description="Updates an existing Order using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Order ID"
     *     ),
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Order")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Order successfully updated",
     *         @SWG\Schema(ref="#/definitions/Order")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad request - validation error"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Order not found"
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
        $modelForm = new OrderUpdateForm($model);
   
        if ($this->load($modelForm)) {
            $modelForm->updateData();

            return $this->response(1, 'Record successfully updated.', $model, null, 200);

        }

        return $this->response(1, 'error.', null, $modelForm->errors, 500);
    }

    /**
     * @SWG\Delete(
     *     path="/v1/order/delete",
     *     tags={"Order"},
     *     summary="Delete a Order by ID.",
     *     description="Deletes the specified Order.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="Order ID"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Order successfully deleted"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Order not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if (DeletedModel::mark($model) === false) {
            throw new ServerErrorHttpException('Failed to delete the Order. Please try again.');
        }
    
       return $this->response(1, 'Record successfully deleted.', null, null, 204);
    }
    
    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id): \common\models\Order|array|null
    {
        if (($model = Order::find()->andWhere(['id' => $id])->onlyActive()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Order not found.');
    }
}
