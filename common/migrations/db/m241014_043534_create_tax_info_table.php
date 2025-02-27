<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tax_info}}`.
 */
class m241014_043534_create_tax_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tax_info}}', [
            'id' => $this->primaryKey(),
            'supplier_buyer_id' => $this->integer()->notNull(), // supplier_buyer jadvali bilan bog'lanadi
            'inn' => $this->string(20), // ИНН
            'kpp' => $this->string(20), // КПП
            'okpo' => $this->string(20), // ОКПО
        ]);

        // foreign key for supplier_buyer table
        $this->addForeignKey(
            'fk-tax_info-supplier_buyer_id',
            '{{%tax_info}}',
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
        $this->dropForeignKey('fk-tax_info-supplier_buyer_id', '{{%tax_info}}');
        $this->dropTable('{{%tax_info}}');
    }
}
