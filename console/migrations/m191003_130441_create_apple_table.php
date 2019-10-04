<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m191003_130441_create_apple_table extends Migration
{
    private $table = '{{%apple}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'color' => 'enum("red", "green", "yellow") not null',
            'created_at' => $this->dateTime()->notNull(),
            'fell_at' => $this->dateTime(),
            'status' => 'enum("on_tree", "fell", "rotten")',
            'ate' => $this->smallInteger()->defaultValue(0),
        ]);

        $this->createIndex('idx_common', $this->table, 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
