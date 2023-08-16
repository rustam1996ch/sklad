<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sell}}`.
 */
class m200222_005904_add_shipped_time_column_to_sell_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sell}}', 'shipped_time', $this->datetime());
        $this->addColumn('{{%sell}}', 'exit_time', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sell}}', 'shipped_time');
        $this->dropColumn('{{%sell}}', 'exit_time');
    }
}
