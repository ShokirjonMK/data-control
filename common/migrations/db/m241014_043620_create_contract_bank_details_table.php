<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contract_bank_details}}`.
 */
class m241014_043620_create_contract_bank_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract_bank_details}}', [
            'id' => $this->primaryKey(),
            'supplier_buyer_id' => $this->integer()->notNull(), // supplier_buyer jadvali bilan bog'lanadi
            'contract_number' => $this->string(100), // Договор номер
            'contract_date' => $this->date(), // Договор Дата
            'bank_details' => $this->text(), // Банковские реквизиты
            'contact_info' => $this->text(), // Контактная информация
            'additional_details' => $this->text(), // Дополнительные реквизиты
            'main_delivery_address' => $this->string(255), // Основной адрес доставки
        ]);

        // foreign key for supplier_buyer table
        $this->addForeignKey(
            'fk-contract_bank_details-supplier_buyer_id',
            '{{%contract_bank_details}}',
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
        $this->dropForeignKey('fk-contract_bank_details-supplier_buyer_id', '{{%contract_bank_details}}');
        $this->dropTable('{{%contract_bank_details}}');
    }
}
