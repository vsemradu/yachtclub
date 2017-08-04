<?php
use yii\db\Schema;
use yii\db\Migration;

class m150817_084501_createTablePinVessel extends Migration
{

    public function up()
    {
        $this->execute("CREATE TABLE `pin_vessels` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`yacht_id` INT(11) NOT NULL,
	`vessel_name` VARCHAR(255) NULL,
	`vessel_draft` VARCHAR(255) NULL,
	`vessel_lenght` VARCHAR(255) NULL,
	`vessel_beam` VARCHAR(255) NULL,
	`vessel_air_draft` VARCHAR(255) NULL,
	`vessel_sail` VARCHAR(255) NULL,
	INDEX `yacht_id` (`yacht_id`),
	PRIMARY KEY (`id`),
	CONSTRAINT `FK__user_pins` FOREIGN KEY (`yacht_id`) REFERENCES `user_pins` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
");
    }

    public function down()
    {

        $this->execute("DROP TABLE `pin_vessels`;");

        echo "m150817_084501_createTablePinVessel reverted.\n";

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
