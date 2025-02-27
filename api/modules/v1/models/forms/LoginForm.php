<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\resources\User;
use yii\base\Model;

class LoginForm extends Model
{
     public $login;
     public $password;

     public function rules()
     {
         return [
             [['login', 'password'], 'required'],
             ['password', 'string', 'min' => 6],
         ];
     }

     public function createAccessToken(): ?array
     {
         $user = User::findByUsername($this->login);

         if ($user && $user->validatePassword($this->password)) {
             return $user->createAccessToken();
         }

         return null;
     }
}