<?php

use yii\db\Migration;

class m170422_154816_content_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string()->notNull(),
            'name_en' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%week_day}}', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string()->notNull(),
            'name_en' => $this->string(),
            'code' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%content}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'user_id' => $this->integer()->notNull(),
            'price_from' => $this->float(),
            'price_to' => $this->float(),
            'is_free' => $this->integer(),
            'date_from' => $this->datetime(),
            'date_to' => $this->datetime(),
            'phone' => $this->string(),
            'site' => $this->string(),
            'file_base_url' => $this->string(),
            'file_url' => $this->string(),
            'status' => $this->integer()->notNull(),
            'city_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_content_user', 'content', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_content_city', 'content', 'city_id', 'city', 'id', 'SET NULL', 'SET NULL');

        $this->createTable('{{%content_category}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'content_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_content_category_category', 'content_category', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_content_category_content', 'content_category', 'content_id', 'content', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%content_week_day}}', [
            'id' => $this->primaryKey(),
            'week_day_id' => $this->integer()->notNull(),
            'content_id' => $this->integer()->notNull(),
            'from' => $this->string()->notNull(),
            'to' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_content_week_day_week_day', 'content_week_day', 'week_day_id', 'week_day', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_content_week_day_week_content', 'content_week_day', 'content_id', 'content', 'id', 'CASCADE', 'CASCADE');




    }

    public function down()
    {
        echo "m170422_154816_content_tables cannot be reverted.\n";

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
