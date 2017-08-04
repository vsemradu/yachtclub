<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_075219_addCrewMembersRoleColumn extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `crew_members` ADD COLUMN `role_id` INT(11) DEFAULT NULL AFTER `role`;");
    }

    public function down()
    {

        $this->execute("ALTER TABLE `crew_members` 	DROP COLUMN `role_id`;");

        echo "m150730_075219_addCrewMembersRoleColumn reverted.\n";

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
