<?php

use yii\db\Migration;

class m200201_142355_015_create_table_receipt extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%receipt}}', [
            'id' => $this->primaryKey(10)->unsigned(),
            'date' => $this->date()->notNull(),
            'product_id' => $this->integer(10)->unsigned()->notNull(),
            'amount' => $this->integer()->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'cost' => $this->decimal(20, 2)->notNull(),
            'packet_id' => $this->integer(10)->unsigned(),
        ], $tableOptions);

        $this->createIndex('fk_receipt_packet1_idx', '{{%receipt}}', 'packet_id');
        $this->createIndex('fk_receipt_product_idx', '{{%receipt}}', 'product_id');
        $this->addForeignKey('fk_receipt_packet1', '{{%receipt}}', 'packet_id', '{{%packet}}', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_receipt_product', '{{%receipt}}', 'product_id', '{{%product}}', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%receipt}}');
    }
}
