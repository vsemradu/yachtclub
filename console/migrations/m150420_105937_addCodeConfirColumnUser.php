<?php
use yii\db\Schema;
use yii\db\Migration;

class m150420_105937_addCodeConfirColumnUser extends Migration
{

    public function up()
    {
        $this->addColumn('{{%user}}', 'code_confirm', Schema::TYPE_STRING . '(255) NOT NULL AFTER fb_id');
    }

    public function down()
    {
        echo "m150420_105937_addCodeConfirColumnUser cannot be reverted.\n";

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
