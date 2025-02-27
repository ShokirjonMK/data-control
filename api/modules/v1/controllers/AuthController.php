<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\forms\LoginForm;
use api\modules\v1\models\forms\RefreshTokenForm;
use api\modules\v1\resources\User;
use common\enum\ResponseMessageEnum;
use common\models\Commit;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class AuthController extends AbstractController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'login' => ['post'],
                'logout' => ['post'],
                'refresh' => ['post'],
            ]
        ];

        return $behaviors;
    }

    public $modelClass = 'api\modules\v1\models\User';

    /**
     * Gets the current authenticated user's details.
     *
     * @SWG\Post(
     *     path="/v1/auth/about-me",
     *     tags={"Auth"},
     *     summary="Get current authenticated user's information.",
     *     description="Returns the details of the authenticated user.",
     *     security={{"Bearer":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="User details",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="username", type="string"),
     *             @SWG\Property(property="email", type="string")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     * @throws NotFoundHttpException
     */
    public function actionAboutMe(): User
    {
        $userId = Yii::$app->user->identity->id;
        $user = User::findOne(['id' => $userId]);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        return $user;
    }

    /**
     * Logs in the user and returns access and refresh tokens.
     *
     * @SWG\Post(
     *     path="/v1/auth/login",
     *     tags={"Auth"},
     *     summary="Login and get access token",
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="login", type="string"),
     *             @SWG\Property(property="password", type="string")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Tokens returned successfully",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="access_token", type="string"),
     *             @SWG\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid username or password"
     *     )
     * )
     * @throws UnauthorizedHttpException
     */
    public function actionLogin(): ?array
    {
        $modelForm = new LoginForm();

        if ($this->load($modelForm)) {
            if ($token = $modelForm->createAccessToken()) {
                return $token;
            }
            return $this->response(1, ResponseMessageEnum::Error->value, null, 'Login yoki parol noto‘g‘ri', 422);
        }

        return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 422);
    }


    /**
     * Refreshes access token using the provided refresh token.
     *
     * @SWG\Post(
     *     path="/v1/auth/refresh",
     *     tags={"Auth"},
     *     summary="Refresh access token using refresh token",
     *     @SWG\Parameter(
     *         name="refresh_token",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="New access token returned",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="access_token", type="string"),
     *             @SWG\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid or expired refresh token"
     *     )
     * )
     * @throws UnauthorizedHttpException
     */
    public function actionRefresh(): ?array
    {
        $modelForm = new RefreshTokenForm;

        if ($this->load($modelForm)) {
            if ($token = $modelForm->refreshToken()) {
                return $token;
            }

            return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 422);
        }

        return $this->response(1, ResponseMessageEnum::Error->value, null, $modelForm->errors, 422);
    }
}
