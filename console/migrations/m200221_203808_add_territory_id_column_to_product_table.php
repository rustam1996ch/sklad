<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m200221_203808_add_territory_id_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'territory_id', $this->integer()->unsigned()->defaultValue(null));
        $this->createIndex(
            'idx-product-territory_id',
            'product',
            'territory_id'
        );
        $this->addForeignKey(
            'fk-product-territory_id',
            'product',
            'territory_id',
            'territory',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-product-territory_id',
            'product'
        );
        $this->dropIndex(
            'idx-product-territory_id',
            'product'
        );
        $this->dropColumn('product', 'territory_id');
    }
}
