<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier_package}}`.
 */
class m241015_090614_create_supplier_package_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier_package}}', [
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer()->notNull(), // ReceivingGoods bilan bog'lanadi
            'nomenclature_package' => $this->string(),  // Упаковка номенклатуры
            'package_quantity' => $this->integer(),  // Количество упаковок
        ]);

        // ReceivingGoods bilan relation qo'shish
        $this->addForeignKey(
            'fk_supplier_package_supplier_id',
            '{{%supplier_package}}',
            'supplier_id',
            '{{%supplier}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_supplier_package_supplier_id', '{{%supplier_package}}');
        $this->dropTable('{{%supplier_package}}');
    }
}
