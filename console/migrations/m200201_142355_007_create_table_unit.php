<?php

use yii\db\Migration;

class m200201_142355_007_create_table_unit extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%unit}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('name_UNIQUE', '{{%unit}}', 'name', true);
    }

    public function down()
    {
        $this->dropTable('{{%unit}}');
    }
}
