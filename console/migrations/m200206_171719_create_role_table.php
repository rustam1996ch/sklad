<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role}}`.
 */
class m200206_171719_create_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(255)->unique()
        ], $tableOptions);

        $this->batchInsert('role',
            [
                'id', 'name'
            ],
            [
                [1, 'admin'],
                [2, 'bugalter'],
                [3, 'sklad'],
                [4, 'buffer'],
                [5, 'rahbar'],
                [6, 'oxrana'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%role}}');
    }
}
