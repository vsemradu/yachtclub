<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_074856_addBuisinessDateColumn extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `business` ADD COLUMN `date_create` INT(11) NOT NULL AFTER `image_id`;");
    }

    public function down()
    {

        $this->execute("ALTER TABLE `business` 	DROP COLUMN `date_create`;");

        echo "m150730_074856_addBuisinessDateColumn reverted.\n";

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
