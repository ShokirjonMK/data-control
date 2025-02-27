<?php

namespace backend\modules\marketplace\controllers;

use api\modules\v1\models\forms\SupplierBuyerCreateForm;
use backend\modules\marketplace\models\forms\MarketPlaceCreateForm;
use backend\modules\marketplace\models\forms\MarketPlaceUpdateForm;
use common\components\DeletedModel;
use common\traits\FormAjaxValidationTrait;
use Yii;
use common\models\SupplierBuyer;
use backend\modules\marketplace\models\search\SupplierBuyerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * SupplierBuyerController implements the CRUD actions for SupplierBuyer model.
 */
class SupplierBuyerController extends Controller
{

    use FormAjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SupplierBuyer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupplierBuyerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SupplierBuyer model.
     * @param int $id ID
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SupplierBuyer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MarketPlaceCreateForm();

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->create();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SupplierBuyer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelForm = new MarketPlaceUpdateForm($model);

        $this->performAjaxValidation($modelForm);

        if ($modelForm->load(Yii::$app->request->post()) && $modelForm->validate()) {
            $modelForm->update();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $modelForm,
        ]);
    }

    /**
     * Deletes an existing SupplierBuyer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (DeletedModel::mark($model) === false) {
            throw new ServerErrorHttpException('Failed to delete the Purveyor. Please try again.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the SupplierBuyer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SupplierBuyer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SupplierBuyer::find()->andWhere(['id' => $id])->onlyActive()->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
