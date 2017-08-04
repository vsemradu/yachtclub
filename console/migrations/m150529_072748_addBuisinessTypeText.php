<?php
use yii\db\Schema;
use yii\db\Migration;

class m150529_072748_addBuisinessTypeText extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `business` ADD COLUMN `type_text` VARCHAR(255) NOT NULL AFTER `type_id`;");
    }

    public function down()
    {

        $this->execute("ALTER TABLE `business` 	DROP COLUMN `type_text`;");

        echo "m150529_072748_addBuisinessTypeText reverted.\n";

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
