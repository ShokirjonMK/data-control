<?php declare(strict_types=1);

namespace common\factories;

use api\modules\v1\models\forms\baseModel\BaseSupplierBuyerModel;
use backend\modules\marketplace\models\forms\MarketPlaceCreateForm;
use common\models\SupplierBuyer;
use common\models\User;

class UserFactory
{
     public function createUser(BaseSupplierBuyerModel $formData): User
     {
        return $this->mapFormToModel($formData, new User());
     }

     public function updateUser(User $user, BaseSupplierBuyerModel $formData): void
     {
         $this->mapFormToModel($formData, $user);
     }

    /**
     * @param MarketPlaceCreateForm $formData
     * @param User $user
     * @return User
     */
    private function mapFormToModel(BaseSupplierBuyerModel $formData, User $user): User
    {
        $user->username = $formData->name_eng . '_' . $formData->id . '_' . uniqid();
        $user->email = $formData->name_eng . '_' . $formData->id . uniqid() . '@mail.ru';
        $user->status = SupplierBuyer::STATUS_NEW;
        $user->tin_number = $formData->inn;
        $user->contract_number = $formData->contract_number;
        $user->phone = '+7' . $formData->inn;
        $user->setPassword($formData->name_eng . time());
        $user->supplier_buyer_id = $formData->id;

        return $user;
    }
}