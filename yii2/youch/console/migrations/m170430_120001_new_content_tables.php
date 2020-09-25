<?php

use yii\db\Migration;

class m170430_120001_new_content_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%content_rating}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'content_id' => $this->integer()->notNull(),
            'rating' => $this->float()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_content_rating_user', 'content_rating', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_content_rating_content', 'content_rating', 'content_id', 'content', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%content_comment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'content_id' => $this->integer()->notNull(),
            'comment' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_content_comment_user', 'content_comment', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_content_comment_content', 'content_comment', 'content_id', 'content', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('{{%content}}', 'rating', $this->float());
    }

    public function down()
    {
        echo "m170430_120001_new_content_tables cannot be reverted.\n";

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
