<?php

use yii\db\Migration;

class m170430_112237_subscription_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_subscription}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'follower_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_user_subscription_user', 'user_subscription', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_subscription_follower', 'user_subscription', 'follower_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m170430_112237_subscription_table cannot be reverted.\n";

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
