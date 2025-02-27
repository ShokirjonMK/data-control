<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_item}}`.
 */
class m241212_115129_create_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'quantity' => $this->integer(),
            'price' => $this->integer(),

            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
            'deleted_at' => $this->integer()->null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->null(),
            'deleted_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            'fk_order_item_order_id',
            'order_items',
            'order_id',
            'order',
            'id'
        );

        $this->addForeignKey(
            'fk_order_item_product_id',
            'order_items',
            'product_id',
            'product',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_order_item_order_id', 'order_items');
        $this->dropForeignKey('fk_order_item_product_id', 'order_items');
        $this->dropTable('{{%order_items}}');
    }
}
