<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gofra}}`.
 */
class m200221_061052_create_gofra_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gofra}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string('255')->notNull(),
        ]);
        $this->insert('gofra', [
            'name' => 'B'
        ]);
        $this->insert('gofra', [
            'name' => 'C_'
        ]);
        $this->insert('gofra', [
            'name' => 'E'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%gofra}}');
    }
}
