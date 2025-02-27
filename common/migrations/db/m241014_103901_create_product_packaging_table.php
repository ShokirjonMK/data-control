<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_packaging}}`.
 */
// Uram va o‘rash bilan bog‘liq ma’lumotlar uchun migratsiya
class m241014_103901_create_product_packaging_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_packaging}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'base_packaging' => $this->string(100)->comment('Asosiy o\'ram'),
            'billing_packaging' => $this->string(100)->comment('Billing uchun o\'ram'),
            'report_packaging' => $this->string(100)->comment('Hisobot uchun o\'ram'),
        ]);

        // Xorijiy kalit qo'shish
        $this->addForeignKey(
            'fk-product_packaging-product_id',
            '{{%product_packaging}}',
            'product_id',
            '{{%product}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_packaging-product_id', '{{%product_packaging}}');
        $this->dropTable('{{%product_packaging}}');
    }
}
