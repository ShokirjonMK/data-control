<?php

use yii\db\Migration;

/**
 * Class m241118_053002_add_supplier_buyer_id_colum_to_user_table
 */
class m241118_053002_add_supplier_buyer_id_colum_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn('user', 'supplier_buyer_id', $this->integer());
         $this->addForeignKey(
             'fk_user_supplier',
             'user',
             'supplier_buyer_id',
             'supplier_buyer',
             'id'
         );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropForeignKey('fk_user_supplier', 'user');
         $this->dropColumn('user', 'supplier_buyer_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241118_053002_add_supplier_buyer_id_colum_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
