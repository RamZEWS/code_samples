<?php

use yii\db\Migration;

class m170422_095921_google_city_autocomplate extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%city}}', 'name_ru', 'name');
        $this->renameColumn('{{%city}}', 'name_en', 'city');
        $this->addColumn('{{%city}}', 'google_id', $this->string());
        $this->addColumn('{{%city}}', 'lat', $this->float());
        $this->addColumn('{{%city}}', 'lng', $this->float());
    }

    public function down()
    {
        echo "m170422_095921_google_city_autocomplate cannot be reverted.\n";

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
