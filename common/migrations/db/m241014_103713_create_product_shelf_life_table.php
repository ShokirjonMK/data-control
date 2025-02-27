<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_shelf_life}}`.
 */
// Saqlash va yaroqlilik muddati ma'lumotlari uchun migratsiya
class m241014_103713_create_product_shelf_life_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_shelf_life}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'shelf_life_stock' => $this->decimal(5, 2)->notNull()->comment('Yaroqlilik zaxirasi'),
            'min_shelf_life_stock' => $this->decimal(5, 2)->comment('Minimal yaroqlilik zaxirasi'),
            'shelf_life_deviation_days' => $this->integer()->comment('Yaroqlilik muddatining chetlashishi kunlarda'),
            'shelf_life_period' => $this->integer()->comment('Yaroqlilik zaxirasi muddati'),
            'min_shelf_life_period' => $this->integer()->comment('Minimal yaroqlilik zaxirasi muddati'),
            'shelf_life_deviation_period' => $this->integer()->comment('Yaroqlilik muddatining chetlashishi muddati'),
            'storage_period_days' => $this->integer()->comment('Saqlash muddati kunlarda'),
            'specification' => $this->text()->notNull()->comment('Spetsifikatsiya'),
            'temperature_mode' => $this->string(100)->notNull()->comment('Harorat rejimi'),
        ]);

        // Xorijiy kalit qo'shish
        $this->addForeignKey(
            'fk-product_shelf_life-product_id',
            '{{%product_shelf_life}}',
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
        $this->dropForeignKey('fk-product_shelf_life-product_id', '{{%product_shelf_life}}');
        $this->dropTable('{{%product_shelf_life}}');
    }
}
