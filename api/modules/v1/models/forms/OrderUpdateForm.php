<?php declare(strict_types=1);

namespace api\modules\v1\models\forms;

use api\modules\v1\models\forms\baseModel\BaseOrderModel;
use common\models\Order;
use common\models\OrderItems;
use yii\db\Exception;

class OrderUpdateForm extends BaseOrderModel
{
   public function __construct(private readonly Order $order, $config = [])
   {
       $this->id = $order->id;
       parent::__construct($config);
   }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function updateData(): void
    {
        executeTransaction(function () {
            $this->order->editData($this);
            updateModel($this->order, 'order');

            $this->order->orderAddress->editData($this);
            updateModel($this->order, 'orderAddress');

            $this->order->unlinkAll('orderItems', true);

            foreach ($this->order_items as $item) {
                $orderAddress = (new OrderItems())->create($item, $this);
                saveModel($orderAddress, 'orderItems');
            }
        });
    }
}