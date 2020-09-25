<?php

use yii\db\Migration;

class m170620_173420_comment_files extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%content_comment}}', 'file_base_url');
        $this->dropColumn('{{%content_comment}}', 'file_url');

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%comment_files}}', [
            'id' => $this->primaryKey(),
            'comment_id' => $this->integer()->notNull(),
            'file_base_url' => $this->string()->notNull(),
            'file_url' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_comment_files_comment', 'comment_files', 'comment_id', 'content_comment', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->addColumn('{{%content_comment}}', 'file_base_url', $this->string());
        $this->addColumn('{{%content_comment}}', 'file_url', $this->string());
        $this->dropTable('{{%comment_files}}');
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
