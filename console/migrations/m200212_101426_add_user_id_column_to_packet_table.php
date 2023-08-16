<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%packet}}`.
 */
class m200212_101426_add_user_id_column_to_packet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('packet', 'user_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('packet', 'user_id');
    }
}
