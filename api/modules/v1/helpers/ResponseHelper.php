<?php

namespace api\modules\v1\helpers;

class ResponseHelper
{
    public static function createResponse($status, $message, $data = null, $errors = null, $responseStatusCode = 200): ?array
    {
        \Yii::$app->response->statusCode = $responseStatusCode;
        $response = [
            //'status' => $status,
            'message' => $message
        ];
        if ($data) $response['data'] = $data;
        if ($errors) $response['errors'] = $errors;

        return $response;
    }
}
