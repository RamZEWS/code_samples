<?php

use yii\db\Migration;

class m170627_154753_period_type extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content}}', 'period_type', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%content}}', 'period_type');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
