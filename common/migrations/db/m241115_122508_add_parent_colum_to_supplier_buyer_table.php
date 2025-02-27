<?php

use yii\db\Migration;

/**
 * Class m241115_122508_add_parent_colum_to_supplier_buyer_table
 */
class m241115_122508_add_parent_colum_to_supplier_buyer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          $this->addColumn('{{%supplier_buyer}}', 'parent_id', $this->integer());

          $this->addForeignKey(
              'fk_supplier_buyer_parent_id',
              '{{%supplier_buyer}}',
              'parent_id',
              '{{%supplier_buyer}}',
              'id',
          );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropForeignKey('fk_supplier_buyer_parent_id', '{{%supplier_buyer}}');
       $this->dropColumn('{{%supplier_buyer}}', 'parent_id');
    }

}
