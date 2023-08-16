<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%territory}}`.
 */
class m200221_202812_create_territory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%territory}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string('255')->notNull(),
        ]);
        $this->insert('territory', [
            'name' => 'Сергели'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%territory}}');
    }
}
