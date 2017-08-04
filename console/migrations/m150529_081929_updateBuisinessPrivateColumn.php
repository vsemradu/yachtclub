<?php
use yii\db\Schema;
use yii\db\Migration;

class m150529_081929_updateBuisinessPrivateColumn extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `business`	ALTER `private` DROP DEFAULT;
ALTER TABLE `business`CHANGE COLUMN `private` `private` INT(11) NOT NULL COLLATE 'utf8_unicode_ci' AFTER `summary`;");
    }

    public function down()
    {
        echo "m150529_081929_updateBuisinessPrivateColumn cannot be reverted.\n";

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
