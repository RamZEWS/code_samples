<?php

use yii\db\Migration;

class m170410_062212_user_new_fields extends Migration
{
    public function up() {
        $this->addColumn('{{%user}}', 'name', $this->string());
        $this->addColumn('{{%user}}', 'about', $this->text());
        $this->addColumn('{{%user}}', 'city_id', $this->integer());
        $this->addForeignKey('fk_user_city', 'user', 'city_id', 'city', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
        echo "m170410_062212_user_new_fields cannot be reverted.\n";

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
