<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
// Mahsulot haqida asosiy ma'lumotlar (masalan, kod, nom, guruhi)
class m241014_103402_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'supplier_buyer_id' => $this->integer()->notNull(),
            'group' => $this->string(255)->notNull()->comment('Mahsulot guruhi'),
            'code' => $this->string(100)->notNull()->unique()->comment('Mahsulot kodi'),
            'name' => $this->string(255)->notNull()->comment('Mahsulot nomi'),
            'full_name' => $this->string(255)->notNull()->comment('Mahsulotning to\'liq nomi'),
            'gtin' => $this->string(50)->unique()->comment('GTIN (Global Trade Item Number)'),
            'article' => $this->string(100)->notNull()->comment('Mahsulotning artikul raqami'),
            'nomenclature_type' => $this->string(100)->notNull()->comment('Nomenklatura turi'),
            'unit' => $this->string(50)->notNull()->comment('O\'lchov birligi'),
            'comment' => $this->text()->comment('Izoh'),

            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
            'deleted_at' => $this->integer()->null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->null(),
            'deleted_by' => $this->integer()->null(),
        ]);

        // foreign key for supplier_buyer table
        $this->addForeignKey(
            'fk-product-supplier_buyer_id',
            '{{%product}}',
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
        $this->dropForeignKey('fk-product-supplier_buyer_id', '{{%product}}');
        $this->dropTable('{{%product}}');
    }
}
