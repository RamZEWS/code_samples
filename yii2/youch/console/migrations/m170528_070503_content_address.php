<?php

use yii\db\Migration;

class m170528_070503_content_address extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content}}', 'address_id', $this->integer());
        $this->addForeignKey('fk_content_address', 'content', 'address_id', 'address', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
        echo "m170528_070503_content_address cannot be reverted.\n";

        return false;
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
