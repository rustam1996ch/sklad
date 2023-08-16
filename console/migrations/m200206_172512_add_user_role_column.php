<?php

use yii\db\Migration;

/**
 * Class m200206_172512_add_user_role_column
 */
class m200206_172512_add_user_role_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role_id', $this->integer()->unsigned()->after('id'));

        $this->createIndex('user_role_idx', 'user', 'role_id');

        $this->addForeignKey('fk_payment_role', 'user', 'role_id', 'role', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_payment_role', 'user');

        $this->dropIndex('user_role_idx', 'user');

        $this->dropColumn('user', 'role_id');
    }
}
