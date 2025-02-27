<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m241106_070447_add_rate_limit_columns_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'rate_limit_allowance', $this->integer()->defaultValue(100)->comment('Remaining requests for rate limiting'));
        $this->addColumn('user', 'rate_limit_allowance_updated_at', $this->integer()->comment('Timestamp of the last rate limit reset'));
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'rate_limit_allowance');
        $this->dropColumn('user', 'rate_limit_allowance_updated_at');
    }
}
