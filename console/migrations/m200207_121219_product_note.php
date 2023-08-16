<?php

use yii\db\Migration;

/**
 * Class m200207_121219_product_note
 */
class m200207_121219_product_note extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->execute('ALTER TABLE `sell` CHANGE `note` `note` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200207_121219_product_note cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200207_121219_product_note cannot be reverted.\n";

        return false;
    }
    */
}
