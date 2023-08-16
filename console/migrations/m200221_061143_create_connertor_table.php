<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%connertor}}`.
 */
class m200221_061143_create_connertor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%connertor}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string('255')->notNull(),
        ]);
        $this->insert('connertor', [
            'name' => 'Степ'
        ]);
        $this->insert('connertor', [
            'name' => 'Клей'
        ]);
        $this->insert('connertor', [
            'name' => 'Нет'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%connertor}}');
    }
}
