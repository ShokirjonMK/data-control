<?php declare(strict_types=1);

namespace backend\modules\marketplace\models\forms;

use api\modules\v1\models\forms\SupplierBuyerCreateForm;
use common\factories\UserFactory;
use Exception;

class MarketPlaceCreateForm extends SupplierBuyerCreateForm
{

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function create(): void
    {
        executeTransaction(function () {

            $this->createData();

            $user = (new UserFactory())->createUser($this);
            saveModel($user, 'user');

        });
    }

}