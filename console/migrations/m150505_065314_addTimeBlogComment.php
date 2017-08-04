<?php
use yii\db\Schema;
use yii\db\Migration;

class m150505_065314_addTimeBlogComment extends Migration
{

    public function up()
    {
        $this->addColumn('{{%blog_post_comments}}', 'date_create', Schema::TYPE_INTEGER . '(11) NOT NULL AFTER text');
    }

    public function down()
    {
        echo "m150505_065314_addTimeBlogComment cannot be reverted.\n";

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
