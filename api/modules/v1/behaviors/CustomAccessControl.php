<?php

namespace api\modules\v1\behaviors;

use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class CustomAccessControl extends AccessControl
{
    protected function isActive($action)
    {
        $user = Yii::$app->user;

        if ($user->isGuest) {
            return false;
        }

        $moduleName = $action->controller->module->id;
        $controllerName = $action->controller->id;
        $actionName = $action->id;

        $permission = "{$moduleName}/{$controllerName}/{$actionName}";

        if (in_array($permission, ['v1/auth/login'])) {
            return true;
        }

        throw new ForbiddenHttpException('Sizda ushbu amalni bajarish uchun ruxsat mavjud emas.');


        $roles = Yii::$app->db->createCommand('
            SELECT r.name
            FROM user_to_role ur
            JOIN roles r ON ur.role_id = r.id
            WHERE ur.user_id = :userId
        ', [':userId' => $user->id])->queryColumn();

        // Rollarga tegishli ruxsatlarni olish
        $permissions = Yii::$app->db->createCommand('
            SELECT p.action_name
            FROM role_to_permission rp
            JOIN permissions p ON rp.permission_id = p.id
            WHERE rp.role_id IN (SELECT role_id FROM user_to_role WHERE user_id = :userId)
        ', [':userId' => $user->id])->queryColumn();

        // Agar ruxsat mavjud bo'lsa, true qaytaradi
        if (in_array($permission, $permissions)) {
            return true;
        }

        throw new ForbiddenHttpException('Sizda ushbu amalni bajarish uchun ruxsat mavjud emas.');
    }
}
