<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_adress}}`.
 */
class m241210_043823_create_order_adress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_address}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'full_name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'city' => $this->string(),
            'region' => $this->string()->notNull(),
            'zip' => $this->string(),
            'country' => $this->string()->notNull(),

            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
            'deleted_at' => $this->integer()->null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->null(),
            'deleted_by' => $this->integer()->null(),
        ]);

        $this->createIndex('{{%idx-order_address-order_id}}', '{{%order_address}}', 'order_id');

        $this->addForeignKey(
            'fk-order_address-order_id',
            'order_address',
            'order_id',
            'order',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-order_address-order_id}}', 'order_address');
        $this->dropForeignKey('fk-order_address-order_id', 'order_address');
        $this->dropTable('{{%order_address}}');
    }
}
