<?php

use yii\db\Migration;

class m170710_164338_content_currency extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content}}', 'currency', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%content}}', 'currency');
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
