<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier_buyer}}`.
 */
class m241014_043351_create_supplier_buyer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier_buyer}}', [
            'id' => $this->primaryKey(),
            'group' => $this->string(255)->notNull(), // Группа поставщика / покупателя
            'code' => $this->string(100)->notNull(), // Код поставщика / покупателя
            'name' => $this->string(255)->notNull(), // Наименование поставщика / покупателя
            'full_name' => $this->string(255)->notNull(), // Полное наименование поставщика / покупателя
            'name_eng' => $this->string(255), // Наименование (англ.)

            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
            'deleted_at' => $this->integer()->null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->null(),
            'deleted_by' => $this->integer()->null(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%supplier_buyer}}');
    }
}
