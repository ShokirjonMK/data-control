<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier_buyer_status}}`.
 */
class m241014_043658_create_supplier_buyer_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier_buyer_status}}', [
            'id' => $this->primaryKey(),
            'supplier_buyer_id' => $this->integer()->notNull(), // supplier_buyer jadvali bilan bog'lanadi
            'is_supplier' => $this->boolean()->notNull()->defaultValue(false), // Поставщик (Да/Нет)
            'is_buyer' => $this->boolean()->notNull()->defaultValue(false), // Покупатель (Да/Нет)
            'depositor' => $this->boolean()->defaultValue(false), // Поклажедатель (Да/Нет)
        ]);

        // foreign key for supplier_buyer table
        $this->addForeignKey(
            'fk-supplier_buyer_status-supplier_buyer_id',
            '{{%supplier_buyer_status}}',
            'supplier_buyer_id',
            '{{%supplier_buyer}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-supplier_buyer_status-supplier_buyer_id', '{{%supplier_buyer_status}}');
        $this->dropTable('{{%supplier_buyer_status}}');
    }
}
