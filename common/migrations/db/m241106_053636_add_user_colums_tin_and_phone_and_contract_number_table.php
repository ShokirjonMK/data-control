<?php

use yii\db\Migration;

/**
 * Class m241106_053636_add_user_colums_tin_and_phone_and_contract_number_table
 */
class m241106_053636_add_user_colums_tin_and_phone_and_contract_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'tin_number', $this->string());
        $this->addColumn('user', 'contract_number', $this->string());
        $this->addColumn('user', 'phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'tin_number');
        $this->dropColumn('user', 'contract_number');
        $this->dropColumn('user', 'phone');
    }

}
