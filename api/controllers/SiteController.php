<?php declare(strict_types=1);

namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * @SWG\Swagger(
 *     basePath="/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="Simple API"),
 * )
 */
class SiteController extends Controller
{

//    public function beforeAction($action)
//    {
//        if (in_array($action->id, ['docs', 'json-schema']) && Yii::$app->request->userIP != '192.168.65.1') {
//            throw new ForbiddenHttpException('You are not allowed to access this page.');
//        }
//        return parent::beforeAction($action);
//    }

        /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'docs' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => Url::to(['site/v1']),
            ],
            'v1' => [
                'class' => \yii2mod\swagger\OpenAPIRenderer::class,
                'scanDir' => [
                    Yii::getAlias('@api/modules/v1/controllers'),
                    Yii::getAlias('@api/modules/v1/models'),
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['site/docs']);
    }

    public function actionError(): \yii\web\Response
    {

        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            $exception = new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        if ($exception instanceof \HttpException) {
            Yii::$app->response->setStatusCode($exception->getCode());
        } else {
            Yii::$app->response->setStatusCode(500);
        }

        return $this->asJson(['error' => $exception->getMessage(), 'code' => $exception->getCode()]);
    }
}