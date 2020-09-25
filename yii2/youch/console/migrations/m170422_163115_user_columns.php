<?php

use yii\db\Migration;

class m170422_163115_user_columns extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'avatar_base_url', $this->string());
        $this->addColumn('{{%user}}', 'avatar_url', $this->string());
        $this->addColumn('{{%user}}', 'site', $this->string());
        $this->addColumn('{{%user}}', 'birthday', $this->date());
        $this->addColumn('{{%user}}', 'get_messages', $this->integer());
        $this->addColumn('{{%user}}', 'hide_events', $this->integer());

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%black_list}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'block_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_black_list_user', 'black_list', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_black_list_block', 'black_list', 'block_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m170422_163115_user_columns cannot be reverted.\n";

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
