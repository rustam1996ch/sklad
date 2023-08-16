<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%client}}`.
 */
class m200207_105040_add_address_column_to_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn('client', 'address', $this->text());
         $this->addColumn('client', 'phone', $this->string(45));
         $this->addColumn('client', 'h_raqam', $this->string(45));
         $this->addColumn('client', 'bank', $this->string(100));
         $this->addColumn('client', 'city', $this->string(45));
         $this->addColumn('client', 'mfo', $this->string(5));
         $this->addColumn('client', 'inn', $this->string(20));
         $this->addColumn('client', 'okonx', $this->string(5));
         $this->addColumn('client', 'director', $this->string(255));
         $this->addColumn('client', 'basis', $this->string(255));
         $this->addColumn('client', 'doc_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropColumn('client', 'address');
         $this->dropColumn('client', 'phone');
         $this->dropColumn('client', 'h_raqam');
         $this->dropColumn('client', 'bank');
         $this->dropColumn('client', 'city');
         $this->dropColumn('client', 'mfo');
         $this->dropColumn('client', 'inn');
         $this->dropColumn('client', 'okonx');
         $this->dropColumn('client', 'director');
         $this->dropColumn('client', 'basis');
         $this->dropColumn('client', 'doc_date');
    }
}
