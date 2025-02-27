<?php declare(strict_types=1);

namespace api\modules\v1\models\forms\baseModel;

use api\modules\v1\resources\OrderItems;
use yii\base\Model;

abstract class BaseOrderModel extends Model
{
    public $id;
    public $order_items;
    public $quantity;
    public $order_id;
    public $status;
    public $created_at;
    public $full_name;
    public $phone;
    public $address;
    public $region;
    public $country;
    public $city;
    public $zip;

    public function rules()
    {
        return [
            [['order_items', 'order_id', 'full_name', 'phone', 'address', 'region', 'country'], 'required'],
            [['full_name', 'phone', 'address', 'city', 'region', 'zip', 'country'], 'string', 'max' => 255],
            ['order_items', 'validateOrderItems'],
        ];
    }

    public function validateOrderItems($attribute, $params)
    {
        if (!is_array($this->order_items)) {
            $this->addError($attribute, 'Order items must be an array.');
            return;
        }

        foreach ($this->order_items as $index => $item) {
            $orderItem = new OrderItems();
            $orderItem->setAttributes($item);

            if (!$orderItem->validate()) {
                $this->addError(
                    $attribute,
                    "Order items at index {$index} is invalid: " . json_encode($orderItem->getErrors())
                );
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'order_items' => 'Order Items',
            'order_id' => 'Order ID',
            'full_name' => 'Full Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'region' => 'Region',
            'country' => 'Country',
            'city' => 'City',
            'zip' => 'Zip',
            'quantity' => 'Quantity',
            'status' => 'Status',
        ];
    }
}