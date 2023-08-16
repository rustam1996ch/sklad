<?php

use yii\db\Migration;

/**
 * Class m200222_002857_create_product_type_table_client_id_column
 */
class m200222_002857_create_product_type_table_client_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product_type', 'client_id', $this->integer(10)->unsigned()->null()->defaultValue(NULL)->after('id'));

        $this->createIndex(
            'idx-product_type-client_id',
            'product_type',
            'client_id'
        );
        $this->addForeignKey(
            'fk-product_type-client_id',
            'product_type',
            'client_id',
            'client',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-product_type-client_id',
            'product_type'
        );
        $this->dropIndex(
            'idx-product_type-client_id',
            'product_type'
        );
        $this->dropColumn('product_type', 'client_id');
    }
}
