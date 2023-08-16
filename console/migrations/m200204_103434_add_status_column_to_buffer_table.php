<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%buffer}}`.
 */
class m200204_103434_add_status_column_to_buffer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('buffer', 'status', $this->tinyInteger(1)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('buffer', 'status');
    }
}
