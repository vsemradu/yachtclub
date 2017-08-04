<?php
use yii\db\Schema;
use yii\db\Migration;

class m150819_113211_updateTablePinVessel extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `pin_vessels` CHANGE COLUMN `yacht_id` `yacht_id` INT(11) NULL AFTER `id`;");
        $this->execute("ALTER TABLE `pin_vessels` CHANGE COLUMN `pin_id` `pin_id` INT(11) NULL AFTER `yacht_id`;");
    }

    public function down()
    {
        echo "m150819_113211_updateTablePinVessel cannot be reverted.\n";

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
