<?php

use yii\db\Schema;
use yii\db\Migration;

class m150902_090824_updatePinFieldAddTypeColumn extends Migration
{
    public function up()
    {
         $this->execute("ALTER TABLE `pin_fields` ADD COLUMN `swell_hight_type` INT(11) NOT NULL AFTER `swell_hight`;");
         $this->execute("ALTER TABLE `pin_fields` ADD COLUMN `max_depth_type` INT(11) NOT NULL AFTER `max_depth`;");
    }

    public function down()
    {
        $this->execute("ALTER TABLE `pin_fields` DROP COLUMN `swell_hight_type`;");
        $this->execute("ALTER TABLE `pin_fields` DROP COLUMN `max_depth_type`;");

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
