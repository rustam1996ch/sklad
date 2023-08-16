<?php

use yii\db\Migration;

class m200201_142355_014_create_table_rasxod extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rasxod}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'amount' => $this->string(45)->notNull(),
            'status' => $this->tinyInteger(4)->notNull()->defaultValue('0'),
            'cost' => $this->decimal(20, 2)->notNull(),
            'product_id' => $this->integer(10)->unsigned()->notNull(),
            'packet_id' => $this->integer(10)->unsigned(),
            'sell_id' => $this->integer(10)->unsigned(),
            'note' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createIndex('fk_rasxod_packet1_idx', '{{%rasxod}}', 'packet_id');
        $this->createIndex('fk_rasxod_product1_idx', '{{%rasxod}}', 'product_id');
        $this->createIndex('fk_rasxod_sell1_idx', '{{%rasxod}}', 'sell_id');
        $this->addForeignKey('fk_rasxod_sell1', '{{%rasxod}}', 'sell_id', '{{%sell}}', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_rasxod_packet1', '{{%rasxod}}', 'packet_id', '{{%packet}}', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_rasxod_product1', '{{%rasxod}}', 'product_id', '{{%product}}', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%rasxod}}');
    }
}
