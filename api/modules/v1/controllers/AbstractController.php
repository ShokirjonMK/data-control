<?php

namespace api\modules\v1\controllers;

use api\modules\v1\behaviors\CorsBehavior;
use api\modules\v1\behaviors\RateLimiterBehavior;
use api\modules\v1\helpers\ResponseHelper;
use common\resolvers\RepositoryResolver;
use Exception;
use ReflectionException;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\di\NotInstantiableException;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;

/**
 * @SWG\Swagger(
 *     swagger="2.0",
 *     schemes={"http", "https"},
 *     basePath="/",
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Fulfillment WMS - BTS Express Cargo Servis",
 *         description="This API is designed to manage fulfillment operations and logistics for BTS Express Cargo Servis.
 *         Created by Muxtorov Tulqin.",
 *         termsOfService="https://example.com/terms",
 *         @SWG\Contact(
 *             name="Support Team",
 *             url="https://example.com/support",
 *             email="support@example.com"
 *         ),
 *         @SWG\License(
 *             name="MIT License",
 *             url="https://opensource.org/licenses/MIT"
 *         ),
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         in="header",
 *         name="Authorization",
 *         description="Use JWT Bearer Token in the Authorization header. Format: 'Bearer {your-token}'"
 *     ),
 * )
 */
abstract class AbstractController extends Controller
{

    protected $repository;

    /**
     * @throws ReflectionException
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function init()
    {
        parent::init();

        $modelClass = $this->resolveModelClass();
        if ($modelClass !== null) {
            if ($modelClass) {
                $this->repository = RepositoryResolver::resolve($modelClass);
            } else {
                throw new \Exception("Model class not defined in " . static::class);
            }
        }
    }

    /**
     * Har bir controller uchun model klassni qaytarish.
     * Bu metodni har bir voris controllerda kengaytiring.
     */
    protected function resolveModelClass(): ?string
    {
        return null;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['rateLimiter'] = [
            'class' => RateLimiterBehavior::class,
        ];

        $behaviors['corsFilter'] = [
            'class' => CorsBehavior::class,
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login', 'refresh'],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['get'],
                'delete' => ['delete'],
                'create' => ['post'],
                'update' => ['put'],
                'view' => ['get'],
            ],
        ];

//        $behaviors['access'] = [
//            'class' => CustomAccessControl::class,
//        ];

        return $behaviors;
    }


    public function response(
        $status,
        $message,
        $data = null,
        $errors = null,
        $responseStatusCode = 200
    ): ?array
    {
        return ResponseHelper::createResponse(
            $status,
            $message,
            $data,
            $errors,
            $responseStatusCode
        );
    }

    public function actions()
    {
        return [];
    }

    /**
     * @throws InvalidConfigException
     */
    protected function load(Model|ActiveRecord $model, bool $isValidate = true): bool
    {
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($isValidate && !$model->validate()) {
                return false;
            }
            return true;
        }
        return false;
    }

}