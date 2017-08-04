<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_074850_addBuisinessOwnerColumn extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `business` ADD COLUMN `owner_id` INT(11) NOT NULL AFTER `user_id`;");
    }

    public function down()
    {

        $this->execute("ALTER TABLE `business` 	DROP COLUMN `owner_id`;");

        echo "m150730_074850_addBuisinessOwnerColumn reverted.\n";

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
