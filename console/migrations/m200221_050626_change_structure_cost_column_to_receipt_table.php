<?php

use yii\db\Migration;

/**
 * Class m200221_050626_change_structure_cost_column_to_receipt_table
 */
class m200221_050626_change_structure_cost_column_to_receipt_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('receipt', 'cost');
        $this->addColumn('receipt', 'cost', $this->decimal(20,2)->defaultValue(null));
        /*$this->execute('ALTER TABLE `receipt` CHANGE `cost` `cost` DECIMAL(20,2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL');*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*$this->execute('ALTER TABLE `receipt` CHANGE `cost` `cost` DECIMAL(20,2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL');*/
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200221_050626_change_structure_cost_column_to_receipt_table cannot be reverted.\n";

        return false;
    }
    */
}
