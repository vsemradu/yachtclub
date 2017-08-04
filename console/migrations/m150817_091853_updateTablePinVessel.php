<?php

use yii\db\Schema;
use yii\db\Migration;

class m150817_091853_updateTablePinVessel extends Migration
{
    public function up()
    {
         $this->execute("ALTER TABLE `pin_vessels`	DROP FOREIGN KEY `FK__user_pins`;");
         $this->execute("ALTER TABLE `pin_vessels`	ADD CONSTRAINT `FK_pin_vessels_yachts` FOREIGN KEY (`yacht_id`) REFERENCES `yachts` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE;");
         $this->execute("ALTER TABLE `pin_vessels`	ADD COLUMN `pin_id` INT(11) NOT NULL AFTER `yacht_id`,	ADD INDEX `pin_id` (`pin_id`),	ADD CONSTRAINT `FK_pin_vessels_user_pins` FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE;");
    }

    public function down()
    {
        echo "m150817_091853_updateTablePinVessel cannot be reverted.\n";

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
