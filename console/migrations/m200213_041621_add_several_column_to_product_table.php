<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m200213_041621_add_several_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'a', $this->float()->defaultValue(null));
        $this->addColumn('product', 'b', $this->float()->defaultValue(null));
        $this->addColumn('product', 'fraction', $this->text()->defaultValue(null));
        $this->addColumn('product', 'amount_in_packet', $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product', 'a');
        $this->dropColumn('product', 'b');
        $this->dropColumn('product', 'fraction');
        $this->dropColumn('product', 'amount_in_packet');
    }
}
