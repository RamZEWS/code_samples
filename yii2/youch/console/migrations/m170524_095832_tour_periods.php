<?php

use yii\db\Migration;

class m170524_095832_tour_periods extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tour_period}}', [
            'id' => $this->primaryKey(),
            'tour_id' => $this->integer()->notNull(),
            'date_start' => $this->datetime()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_tour_period_tour', 'tour_period', 'tour_id', 'content', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('{{%content}}', 'period', $this->integer());
    }

    public function down()
    {
        return true;
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
