<?php declare(strict_types=1);

namespace api\modules\v1\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class User extends \common\models\User implements Linkable
{
    public function fields()
    {
        return ['id', 'username', 'email', 'status'];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true)
        ];
    }
}
