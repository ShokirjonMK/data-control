<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier}}`.
 */
class m241015_090436_create_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey(),
            'number' => $this->string()->notNull(),
            'date' => $this->date()->notNull(),
            'counterparty' => $this->string()->notNull(),  // Контрагент
            'arrival_date' => $this->date(),  // Дата поступления
            'comment' => $this->text(),  // Комментарий
            'vehicle_model' => $this->string(),  // Модель ТС
            'vehicle_number' => $this->string(),  // ГосНомер ТС
            'driver_name' => $this->string(),  // Водитель ФИО
            'driver_document' => $this->string(),  // Водитель Документ
            'contract_number' => $this->string(),  // Договор номер
            'contract_date' => $this->date(),  // Договор Дата
            'acceptance_gate' => $this->string(),  // Ворота приемки
            'nomenclature' => $this->string()->notNull(),  // Номенклатура
            'quantity' => $this->integer()->notNull(),  // Количество
            'price' => $this->decimal(10, 2)->notNull(),  // Цена
            'total_amount' => $this->decimal(10, 2)->notNull(),  // Сумма

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
        $this->dropTable('{{%supplier}}');
    }
}
