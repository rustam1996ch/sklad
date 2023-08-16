<?php

use yii\db\Migration;

class m200201_142355_006_create_table_sell extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sell}}', [
            'id' => $this->primaryKey(10)->unsigned(),
            'date' => $this->date()->notNull(),
            'car_number' => $this->string(45),
            'note' => $this->text()->notNull(),
            'client_id' => $this->integer(10)->unsigned()->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue('0'),
        ], $tableOptions);

        $this->createIndex('fk_sell_client1_idx', '{{%sell}}', 'client_id');
        $this->addForeignKey('fk_sell_client1', '{{%sell}}', 'client_id', '{{%client}}', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%sell}}');
    }
}
