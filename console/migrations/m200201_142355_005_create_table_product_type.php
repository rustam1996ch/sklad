<?php

use yii\db\Migration;

class m200201_142355_005_create_table_product_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_type}}', [
            'id' => $this->primaryKey(10)->unsigned(),
            'name' => $this->string()->notNull(),
            'parent' => $this->integer()->notNull()->defaultValue('0'),
            'no' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('name_UNIQUE', '{{%product_type}}', 'name', true);
    }

    public function down()
    {
        $this->dropTable('{{%product_type}}');
    }
}
