<?php

namespace console\services;

use console\interfaces\GeneratorInterface;

class CrudControllerGenerator implements GeneratorInterface
{
    public function generate($modelName, $path)
    {
        $lowerModelName = strtolower($modelName);

        $content = <<<PHP
<?php

namespace api\\modules\\v1\\controllers;

use api\\modules\\v1\\resources\\{$modelName};
use common\\base\\BaseFilter;
use common\\base\\search\\DefaultDataProvider;
use common\\base\\search\\DefaultFilter;
use yii\\web\\NotFoundHttpException;
use yii\\web\\ServerErrorHttpException;
use common\\components\\DeletedModel;
use Yii;
use api\\modules\\v1\\controllers\\AbstractController;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

/**
 * {$modelName}Controller implements the CRUD actions for {$modelName} model.
 */
class {$modelName}Controller extends AbstractController
{

    /**
     * @SWG\Get(
     *     path="/v1/{$lowerModelName}/index",
     *     tags={"{$modelName}"},
     *     summary="Get the collection of {$modelName}s.",
     *     description="Returns the list of {$modelName}s.",
     *     @SWG\Parameter(
     *             name="id",
     *             in="query",
     *             description="{$modelName}s ID",
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
     *         description="{$modelName} collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/{$modelName}")
     *         )
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionIndex()
    {
        \$model = new {$modelName}();
        
        \$data = new BaseFilter(
            model: \$model, 
            query: \$model->find(), 
            dataProvider:  new DefaultDataProvider,
            filter: new DefaultFilter
        );

        return \$this->response(1, 'Data successfully retrieved.', \$data->getData());
    }

    /**
     * @SWG\Post(
     *     path="/v1/{$lowerModelName}/create",
     *     tags={"{$modelName}"},
     *     summary="Create a new {$modelName}.",
     *     description="Creates a new {$modelName} using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/{$modelName}")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="{$modelName} successfully created",
     *         @SWG\Schema(ref="#/definitions/{$modelName}")
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
        \$model = new {$modelName}();

        if (\$model->load(Yii::\$app->getRequest()->getBodyParams(), '') && \$model->validate()) {
            if (\$model->save()){
                return \$this->response(1, 'Record successfully created.', \$model, null, 201);
            }
        }

        return \$this->response(1, 'error.', null, \$model->errors, 500);

    }

    /**
     * @SWG\Get(
     *     path="/v1/{$lowerModelName}/view",
     *     tags={"{$modelName}"},
     *     summary="Get a {$modelName} by ID.",
     *     description="Returns a single {$modelName} identified by its ID.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="{$modelName} ID"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="{$modelName} details",
     *         @SWG\Schema(ref="#/definitions/{$modelName}")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="{$modelName} not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionView(\$id)
    {
        \$model = \$this->findModel(\$id);
    
        return \$this->response(1, 'Record successfully retrieved.', \$model, null, 200);
    }

    /**
     * @SWG\Put(
     *     path="/v1/{$lowerModelName}/update",
     *     tags={"{$modelName}"},
     *     summary="Update an existing {$modelName}.",
     *     description="Updates an existing {$modelName} using the provided data.",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="{$modelName} ID"
     *     ),
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/{$modelName}")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="{$modelName} successfully updated",
     *         @SWG\Schema(ref="#/definitions/{$modelName}")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad request - validation error"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="{$modelName} not found"
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Server error"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function actionUpdate(\$id)
    {
        \$model = \$this->findModel(\$id);
   
        if (\$model->load(Yii::\$app->getRequest()->getBodyParams(), '') && \$model->validate()) {
            if (\$model->save()) {
               return \$this->response(1, 'Record successfully updated.', \$model, null, 200);
            }
        }

        throw new ServerErrorHttpException('Failed to update the {$modelName}. Please try again.');
    }

    /**
     * @SWG\Delete(
     *     path="/v1/{$lowerModelName}/delete",
     *     tags={"{$modelName}"},
     *     summary="Delete a {$modelName} by ID.",
     *     description="Deletes the specified {$modelName}.",
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         description="{$modelName} ID"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="{$modelName} successfully deleted"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="{$modelName} not found"
     *     ),
     *     security={{"Bearer":{}}}
     * )
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionDelete(\$id)
    {
        \$model = \$this->findModel(\$id);
        
        if (DeletedModel::mark(\$model) === false) {
            throw new ServerErrorHttpException('Failed to delete the {$modelName}. Please try again.');
        }
    
       return \$this->response(1, 'Record successfully deleted.', null, null, 204);


    }
    
    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(\$id): \\common\\models\\{$modelName}|array|null
    {
        if ((\$model = {$modelName}::find()->andWhere(['id' => \$id])->one()) !== null) {
            return \$model;
        }

        throw new NotFoundHttpException('{$modelName} not found.');
    }
}

PHP;

        file_put_contents("$path/{$modelName}Controller.php", $content);
    }

}
