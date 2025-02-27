<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%commit}}`.
 */
class m241012_045955_create_commit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%commit}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%commit}}');
    }
}
