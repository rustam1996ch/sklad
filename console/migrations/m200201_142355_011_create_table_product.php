<?php

use yii\db\Migration;

class m200201_142355_011_create_table_product extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(10)->unsigned(),
            'name' => $this->string()->notNull(),
            'product_type_id' => $this->integer(10)->unsigned()->notNull(),
            'mark' => $this->string(),
            'vendor_code' => $this->string(80),
            'x' => $this->integer(),
            'y' => $this->integer(),
            'z' => $this->integer(),
            'mkv' => $this->float(),
            'cost' => $this->decimal(20, 2),
            'price' => $this->decimal(20, 2),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'unit_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('fk_product_product_type1_idx', '{{%product}}', 'product_type_id');
        $this->createIndex('vendor_code_UNIQUE', '{{%product}}', 'vendor_code', true);
        $this->createIndex('fk_product_unit1_idx', '{{%product}}', 'unit_id');
        $this->addForeignKey('fk_product_product_type1', '{{%product}}', 'product_type_id', '{{%product_type}}', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_product_unit1', '{{%product}}', 'unit_id', '{{%unit}}', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%product}}');
    }
}
