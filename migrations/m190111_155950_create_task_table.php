<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m190111_155950_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id'         => $this->primaryKey(),
            'text'       => $this->string(),
            'up_to'      => $this->integer()->notNull(),
            'status'     => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull()
        ]);

        $this->createIndex('idx-task-status', '{{%task}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
