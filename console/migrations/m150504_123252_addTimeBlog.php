<?php
use yii\db\Schema;
use yii\db\Migration;

class m150504_123252_addTimeBlog extends Migration
{

    public function up()
    {
        $this->addColumn('{{%blog_posts}}', 'date_create', Schema::TYPE_INTEGER . '(11) NOT NULL AFTER type');
    }

    public function down()
    {
        echo "m150504_123252_addTimeBlog cannot be reverted.\n";

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
