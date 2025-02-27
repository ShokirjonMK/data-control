<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%supplier_buyer}}`.
 */
class m241106_094344_add_customer_status_column_to_supplier_buyer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%supplier_buyer}}', 'customer_status', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%supplier_buyer}}', 'customer_status');
    }
}
