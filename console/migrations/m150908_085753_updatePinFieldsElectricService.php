<?php
use yii\db\Schema;
use yii\db\Migration;

class m150908_085753_updatePinFieldsElectricService extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `pin_fields` CHANGE COLUMN `electric_services` `electric_services` TEXT NOT NULL AFTER `restaurant`;");
    }

    public function down()
    {
        $this->execute("ALTER TABLE `pin_fields` CHANGE COLUMN `electric_services` `electric_services` INT(11) NOT NULL DEFAULT '0' AFTER `restaurant`;");

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
