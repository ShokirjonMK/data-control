<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity_type}}`.
 */
class m241014_043431_create_entity_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%entity_type}}', [
            'id' => $this->primaryKey(),
            'stock_percentage' => $this->decimal(5, 2), // Процент запаса годности
            'stock_expiry' => $this->integer(), // Срок запаса годности
            'supplier_buyer_id' => $this->integer()->notNull(), // supplier_buyer jadvali bilan bog'lanadi
            'legal_entity' => $this->boolean()->notNull()->defaultValue(false), // Юр/ФизЛицо
        ]);

        // foreign key for supplier_buyer table
        $this->addForeignKey(
            'fk-entity_type-supplier_buyer_id',
            '{{%entity_type}}',
            'supplier_buyer_id',
            '{{%supplier_buyer}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-entity_type-supplier_buyer_id', '{{%entity_type}}');
        $this->dropTable('{{%entity_type}}');
    }
}
