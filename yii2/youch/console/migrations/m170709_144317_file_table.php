<?php

use yii\db\Migration;

class m170709_144317_file_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'file_base_url' => $this->string()->notNull(),
            'file_url' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        /* For comments */
        $this->truncateTable('{{%comment_files}}');
        $this->addColumn('{{%comment_files}}', 'file_id', $this->integer()->notNull());
        $this->dropColumn('{{%comment_files}}', 'file_base_url');
        $this->dropColumn('{{%comment_files}}', 'file_url');
        $this->addForeignKey('fk_comment_files_file', 'comment_files', 'file_id', 'file', 'id', 'CASCADE', 'CASCADE');

        /* For content*/
        $this->addColumn('{{%content}}', 'file_id', $this->integer());
        $this->dropColumn('{{%content}}', 'file_base_url');
        $this->dropColumn('{{%content}}', 'file_url');
        $this->addForeignKey('fk_content_file', 'content', 'file_id', 'file', 'id', 'SET NULL', 'SET NULL');

        /* For User */
        $this->addColumn('{{%user}}', 'avatar_id', $this->integer());
        $this->dropColumn('{{%user}}', 'avatar_base_url');
        $this->dropColumn('{{%user}}', 'avatar_url');
        $this->addForeignKey('fk_user_avatar', 'user', 'avatar_id', 'file', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
        $this->dropTable('{{%file}}');
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
