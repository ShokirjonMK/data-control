<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m241118_072251_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'total_price' => $this->decimal(10, 2),
            'order_id' => $this->integer(),
            'supplier_buyer_id' => $this->integer(),

            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
            'deleted_at' => $this->integer()->null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->null(),
            'deleted_by' => $this->integer()->null(),
        ]);

        $this->createIndex('{{%idx-order-supplier_buyer_id}}', '{{%order}}', 'supplier_buyer_id');
        $this->addForeignKey(
            'fk-order-supplier_buyer_id',
            'order',
            'supplier_buyer_id',
            'supplier_buyer',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-order-supplier_buyer_id}}', '{{%order}}');
        $this->dropForeignKey('fk-order-supplier_buyer_id', '{{%order}}');
        $this->dropTable('{{%order}}');
    }
}


