<?php
use yii\db\Schema;
use yii\db\Migration;

class m150731_141243_addColumnRateYacht extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `yachts` ADD COLUMN `rate` INT(11) NOT NULL DEFAULT '0' AFTER `contact_info`;");
    }

    public function down()
    {
        
        $this->execute("ALTER TABLE `yachts` DROP COLUMN `rate`;");
        
        echo "m150731_141243_addColumnRateYacht reverted.\n";

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
