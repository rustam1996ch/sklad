<?php

use yii\db\Migration;

/**
 * Class m200222_003450_product_type_parent_to_parent_id
 */
class m200222_003450_product_type_parent_to_parent_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('product_type', 'parent', 'parent_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('product_type', 'parent_id', 'parent');
    }

}
