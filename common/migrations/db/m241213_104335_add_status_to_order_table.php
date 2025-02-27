<?php

use yii\db\Migration;

/**
 * Class m241213_104335_add_status_to_order_table
 */
class m241213_104335_add_status_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'order_status', $this->integer()->notNull()->defaultValue(1)->comment('Order status'));

        $this->addColumn('{{%order}}', 'delivery_status', $this->integer()->notNull()->defaultValue(1)->comment('Delivery status'));

        $this->addColumn('{{%order}}', 'fulfillment_status', $this->integer()->notNull()->defaultValue(1)->comment('Fulfillment status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'order_status');
        $this->dropColumn('{{%order}}', 'delivery_status');
        $this->dropColumn('{{%order}}', 'fulfillment_status');
    }
}
