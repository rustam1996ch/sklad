<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%buffer}}`.
 */
class m200311_030645_drop_buffer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            DROP TABLE IF EXISTS `buffer`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Ok";
    }
}
