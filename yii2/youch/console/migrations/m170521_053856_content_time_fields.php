<?php

use yii\db\Migration;

class m170521_053856_content_time_fields extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content}}', 'time_from', $this->string());
        $this->addColumn('{{%content}}', 'time_to', $this->string());
    }

    public function down()
    {
        echo "m170521_053856_content_time_fields cannot be reverted.\n";

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
