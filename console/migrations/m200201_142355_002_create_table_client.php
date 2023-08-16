<?php

use yii\db\Migration;

class m200201_142355_002_create_table_client extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(10)->unsigned(),
            'name' => $this->string(1000)->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%client}}');
    }
}
