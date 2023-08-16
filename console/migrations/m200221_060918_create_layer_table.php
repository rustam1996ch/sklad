<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%layer}}`.
 */
class m200221_060918_create_layer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%layer}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string('255')->notNull(),
        ]);

        $this->insert('layer', [
            'name' => 'K 100'
        ]);
        $this->insert('layer', [
            'name' => 'K 125'
        ]);
        $this->insert('layer', [
            'name' => 'KW 160'
        ]);
        $this->insert('layer', [
            'name' => 'NM 125'
        ]);
        $this->insert('layer', [
            'name' => 'S 100'
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%layer}}');
    }
}
