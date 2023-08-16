<?php

use yii\db\Migration;

class m200201_142355_004_create_table_payment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'client_id' => $this->integer(10)->unsigned()->notNull(),
            'amount' => $this->decimal(20, 2)->notNull(),
            'note' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createIndex('fk_payment_client1_idx', '{{%payment}}', 'client_id');
        $this->addForeignKey('fk_payment_client1', '{{%payment}}', 'client_id', '{{%client}}', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%payment}}');
    }
}
