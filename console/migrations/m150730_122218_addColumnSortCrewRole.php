<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_122218_addColumnSortCrewRole extends Migration
{

    public function up()
    {

        $this->execute("ALTER TABLE `crew_member_roles`	ADD COLUMN `sort` INT(11) NOT NULL DEFAULT '0' AFTER `name`;");
    }

    public function down()
    {

        $this->execute("ALTER TABLE `crew_member_roles` DROP COLUMN `sort`;");
        echo "m150730_122218_addColumnSortCrewRole reverted.\n";

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
