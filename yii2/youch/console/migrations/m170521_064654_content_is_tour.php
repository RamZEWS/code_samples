<?php

use yii\db\Migration;

class m170521_064654_content_is_tour extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content}}', 'is_tour', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%content}}', 'is_tour');
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
