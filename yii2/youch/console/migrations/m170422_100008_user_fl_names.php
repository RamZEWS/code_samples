<?php

use yii\db\Migration;

class m170422_100008_user_fl_names extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%user}}', 'name', 'first_name');
        $this->addColumn('{{%user}}', 'last_name', $this->string());
    }

    public function down()
    {
        echo "m170422_100008_user_fl_names cannot be reverted.\n";

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
