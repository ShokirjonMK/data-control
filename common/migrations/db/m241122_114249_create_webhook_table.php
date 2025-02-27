<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%webhook}}`.
 */
class m241122_114249_create_webhook_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%webhook}}', [
            'id' => $this->primaryKey(),
            'supplier_buyer_id' => $this->integer(),
            'url' => $this->string(),
            'token' => $this->string(),
            'status' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-webhook-supplier_buyer_id',
            'webhook',
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
        $this->dropForeignKey('fk-webhook-supplier_buyer_id', 'webhook');
        $this->dropTable('{{%webhook}}');
    }
}
