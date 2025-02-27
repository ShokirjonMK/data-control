<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%supplier}}`.
 */
class m241106_094322_add_customer_status_column_to_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%supplier}}', 'customer_status', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%supplier}}', 'customer_status');
    }
}
