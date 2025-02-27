<?php declare(strict_types=1);

namespace common\components;

use Yii;

class DeletedModel
{
    public static function mark(?object $model): bool
    {
        $model->deleted_at = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
        $model->deleted_by = Yii::$app->user->identity->getId();

        if ($model->save(false)){
            return true;
        }
        return false;
    }
}