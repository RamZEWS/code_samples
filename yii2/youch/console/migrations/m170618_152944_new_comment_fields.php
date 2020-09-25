<?php

use yii\db\Migration;

class m170618_152944_new_comment_fields extends Migration
{
    public function up()
    {

        $this->addColumn('{{%content_comment}}', 'comment_id', $this->integer());
        $this->addColumn('{{%content_comment}}', 'rating', $this->float());
        $this->addColumn('{{%content_comment}}', 'file_base_url', $this->string());
        $this->addColumn('{{%content_comment}}', 'file_url', $this->string());

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%comment_rating}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'comment_id' => $this->integer()->notNull(),
            'rating' => $this->float()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_comment_rating_user', 'comment_rating', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_comment_rating_comment', 'comment_rating', 'comment_id', 'content_comment', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('{{%content_comment}}', 'comment_id');
        $this->dropColumn('{{%content_comment}}', 'rating');
        $this->dropColumn('{{%content_comment}}', 'file_base_url');
        $this->dropColumn('{{%content_comment}}', 'file_url');
        $this->dropTable('{{%comment_rating}}');
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
