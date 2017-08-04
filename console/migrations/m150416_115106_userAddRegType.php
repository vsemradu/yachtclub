<?php
use yii\db\Schema;
use yii\db\Migration;

class m150416_115106_userAddRegType extends Migration
{

    public function up()
    {
        $this->addColumn('{{%user}}', 'reg_type', Schema::TYPE_INTEGER . ' NOT NULL AFTER fb_id');
    }

    public function down()
    {
        echo "m150416_115106_userAddRegType cannot be reverted.\n";

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
