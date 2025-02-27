<?php declare(strict_types=1);

use common\models\SupplierBuyer;
use yii\db\ActiveRecord;

function formatErrors(?ActiveRecord $model): ?string
{
    $errorMessages = [];

    foreach ($model->errors as $attribute => $errors) {
        $errorMessages[] = "$attribute: " . implode(', ', $errors);
    }

    return implode('; ', $errorMessages);
}

/**
 * @throws Exception
 */
function saveModel($model, $modelName): void
{
    if (!$model->save()) {
        $errors = formatErrors($model);
        throw new Exception("$modelName: Произошла ошибка при сохранении данных: $errors");
    }
}

/**
 * @throws Exception
 */
function updateModel($model, $modelName): void
{
    if ($model->update() === false) {
        $errors = formatErrors($model);
        throw new Exception("$modelName: Произошла ошибка при сохранении данных: $errors");
    }
}

/**
 * @throws \yii\db\Exception
 */
function executeTransaction(callable $callback): void
{
    $transaction = Yii::$app->db->beginTransaction();

    try {
        $callback();
        $transaction->commit();
    } catch (Exception $e) {
        $transaction->rollBack();
        throw $e;
    }
}


function supplierBuyerIdentityId()
{
   return SupplierBuyer::findOne(['id' => Yii::$app->user->identity->supplier_buyer_id])->id;
}

function www($data)
{
    echo "<pre>";
    print_r($data);
    die();
}
