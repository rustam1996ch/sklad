<?php

use yii\db\Migration;

/**
 * Class m200221_181918_insert_name_column_to_unit_table
 */
class m200221_181918_insert_name_column_to_unit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $unit = \sklad\models\Unit::find()->where(['name' => 'шт'])->one();
        if(!isset($unit)){
            $this->insert('unit', [
                'name' => 'шт'
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200221_181918_insert_name_column_to_unit_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200221_181918_insert_name_column_to_unit_table cannot be reverted.\n";

        return false;
    }
    */
}
