<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%receipt}}`.
 */
class m200214_045505_add_move_column_to_receipt_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('receipt', 'move_user_id', $this->integer()->defaultValue(null));
        $this->addColumn('receipt', 'move_who', $this->tinyInteger(1)->defaultValue(null));//bufferdan skladga o'tsa => 0 ; packetdan skladga o'tsa => 1
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('receipt', 'move_user_id');
        $this->dropColumn('receipt', 'move_who');
    }
}
