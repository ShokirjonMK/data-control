<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rateLimit}}`.
 */
class m241107_115050_create_rateLimit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rate_limit}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(45),
            'user_id' => $this->integer(),
            'rate_limit' => $this->integer(),
            'time_period' => $this->integer(),
            'request_count' => $this->integer(),
            'type' => $this->integer(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        
        $this->insert('{{%rate_limit}}', [
            'rate_limit' => 50,
            'time_period' => 600,
            'type' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%rate_limit}}', [
            'rate_limit' => 100,
            'time_period' => 600,
            'type' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rate_limit}}');
    }
}
