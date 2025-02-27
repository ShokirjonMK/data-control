<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_technical}}`.
 */
// Texnik parametrlar uchun migratsiya
class m241014_103530_create_product_technical_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_technical}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'weight' => $this->decimal(10, 3)->comment('Og\'irlik'),
            'net_weight' => $this->decimal(10, 3)->comment('Og\'irlik (netto)'),
            'volume' => $this->decimal(10, 3)->comment('Hajm'),
            'net_volume' => $this->decimal(10, 3)->comment('Hajm (netto)'),
            'is_set' => $this->boolean()->notNull()->defaultValue(false)->comment('To\'plam (Komplekt)'),
            'kis_code' => $this->string(50)->notNull()->comment('KIS kodi'),
            'default_status' => $this->string(100)->defaultValue('Кондиция')->comment('Holat'),
        ]);

        // `product_technical` jadvaliga xorijiy kalit qo'shish
        $this->addForeignKey(
            'fk-product_technical-product_id',
            '{{%product_technical}}',
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
        $this->dropForeignKey('fk-product_technical-product_id', '{{%product_technical}}');
        $this->dropTable('{{%product_technical}}');
    }
}
