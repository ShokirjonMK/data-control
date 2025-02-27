<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier_details}}`.
 */
class m241015_090530_create_supplier_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier_details}}', [
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer()->notNull(), // ReceivingGoods bilan bog'lanadi
            'kis_number' => $this->string(),  // Номер КИС
            'kis_date' => $this->date(),  // Дата КИС
            'accept_by_places' => $this->boolean(),  // Приемка по грузовым местам
            'vehicle_type' => $this->string(),  // Транспортное средство
            'vat_rate' => $this->decimal(5, 2),  // Ставка НДС
            'vat_amount' => $this->decimal(10, 2),  // Сумма НДС
            'price_includes_vat' => $this->boolean(),  // Цена включает НДС
            'discount_amount' => $this->decimal(10, 2),  // Сумма скидки
            'under_delivery_percent' => $this->decimal(5, 2),  // Процент недопоставки
            'over_delivery_percent' => $this->decimal(5, 2),  // Процент перепоставки
        ]);

        // ReceivingGoods bilan relation qo'shish
        $this->addForeignKey(
            'fk_supplier_details_supplier_id',
            '{{%supplier_details}}',
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
        $this->dropForeignKey('fk_supplier_details_supplier_id', '{{%supplier_details}}');
        $this->dropTable('{{%supplier_details}}');
    }
}
