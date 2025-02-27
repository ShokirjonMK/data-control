<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseOrderModel;
use common\models\Order;
use common\models\OrderAddress;
use common\models\OrderItems;
use yii\db\Exception;

class OrderCreateForm extends BaseOrderModel
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function createData(): void
    {
        executeTransaction(function () {

            $order = (new Order())->create($this);
            saveModel($order, 'order');

            $this->id = $order->id;

            $orderAddress = (new OrderAddress())->create($this);
            saveModel($orderAddress, 'order_address');

            foreach ($this->order_items as $item) {
                $orderAddress = (new OrderItems())->create($item, $this);
                saveModel($orderAddress, 'order_address');
            }
        });
    }
}