<?php

use yii\db\Migration;

/**
 * Class m241105_112840_add_product_customer_status_table
 */
class m241105_112840_add_product_customer_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'customer_status', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'customer_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241105_112840_add_product_customer_status_table cannot be reverted.\n";

        return false;
    }
    */
}
