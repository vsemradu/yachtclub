<?php
use yii\db\Schema;
use yii\db\Migration;

class m150416_091128_userAddRoleFb extends Migration
{

    public function up()
    {
//        $tableOptions = null;
//        if ($this->db->driverName === 'mysql') {
//            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
//            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//        }

        $this->addColumn('{{%user}}', 'role', Schema::TYPE_STRING . '(255) NOT NULL AFTER username');
        $this->addColumn('{{%user}}', 'fb_id', Schema::TYPE_STRING . '(255) NOT NULL AFTER role');
    }

    public function down()
    {
        echo "m150416_091128_userAddRoleFb cannot be reverted.\n";

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
