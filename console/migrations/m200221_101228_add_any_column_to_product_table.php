<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m200221_101228_add_any_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'layer1_id', $this->integer()->defaultValue(null));
        $this->addColumn('product', 'layer2_id', $this->integer()->defaultValue(null));
        $this->addColumn('product', 'layer3_id', $this->integer()->defaultValue(null));
        $this->addColumn('product', 'layer4_id', $this->integer()->defaultValue(null));
        $this->addColumn('product', 'layer5_id', $this->integer()->defaultValue(null));
        $this->addColumn('product', 'gofra1_id', $this->integer()->defaultValue(null));
        $this->addColumn('product', 'gofra2_id', $this->integer()->defaultValue(null));
        $this->addColumn('product', 'connertor_id', $this->integer()->unsigned()->defaultValue(null));
        $this->addColumn('product', 'weight_gofra', $this->decimal(20,2)->defaultValue(null));
        $this->addColumn('product', 'point_connector', $this->tinyInteger(2)->defaultValue(null));

        $this->createIndex(
            'idx-product-connertor_id',
            'product',
            'connertor_id'
        );
        $this->addForeignKey(
            'fk-product-connertor_id',
            'product',
            'connertor_id',
            'connertor',
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
            'fk-product-connertor_id',
            'product'
        );
        $this->dropIndex(
            'idx-product-connertor_id',
            'product'
        );

        $this->dropColumn('product', 'layer1_id');
        $this->dropColumn('product', 'layer2_id');
        $this->dropColumn('product', 'layer3_id');
        $this->dropColumn('product', 'layer4_id');
        $this->dropColumn('product', 'layer5_id');
        $this->dropColumn('product', 'gofra1_id');
        $this->dropColumn('product', 'gofra2_id');
        $this->dropColumn('product', 'connertor_id');
        $this->dropColumn('product', 'weight_gofra');
        $this->dropColumn('product', 'point_connector');
    }
}
