<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sell}}`.
 */
class m200221_201638_add_invoice_no_column_to_sell_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sell}}', 'invoice_no', $this->integer());
        $this->addColumn('{{%sell}}', 'contract_no', $this->integer());
        $this->addColumn('{{%sell}}', 'contract_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sell}}', 'invoice_no');
        $this->dropColumn('{{%sell}}', 'contract_no');
        $this->dropColumn('{{%sell}}', 'contract_date');
    }
}
