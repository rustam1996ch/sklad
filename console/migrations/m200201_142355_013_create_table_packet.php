<?php

use yii\db\Migration;

class m200201_142355_013_create_table_packet extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%packet}}', [
            'id' => $this->primaryKey(10)->unsigned(),
            'product_id' => $this->integer(10)->unsigned()->notNull(),
            'amount' => $this->integer()->notNull(),
            'note' => $this->text()->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'left' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'space' => $this->tinyInteger(1)->notNull()->defaultValue('0'),
        ], $tableOptions);

        $this->createIndex('fk_packet_product1_idx', '{{%packet}}', 'product_id');
        $this->addForeignKey('fk_packet_product1', '{{%packet}}', 'product_id', '{{%product}}', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%packet}}');
    }
}
