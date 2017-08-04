<?php
use yii\db\Schema;
use yii\db\Migration;

class m150519_123431_createTablePinField extends Migration
{

    public function up()
    {
        $this->execute("CREATE TABLE `pin_fields` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`pin_id` INT(11) NOT NULL,
	`type_id` INT(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`rating` INT(11) NOT NULL,
	`quality_rating` INT(11) NOT NULL,
	`novice` INT(11) NOT NULL,
	`intermidiate` INT(11) NOT NULL,
	`expert` INT(11) NOT NULL,
	`warnings` TEXT NOT NULL,
	`sea_swell` VARCHAR(255) NOT NULL,
	`wind_direction` VARCHAR(255) NOT NULL,
	`overnight_price` VARCHAR(255) NOT NULL,
	`ice` INT(11) NOT NULL,
	`provisions` INT(11) NOT NULL,
	`pestaurant` INT(11) NOT NULL,
	`fuel` INT(11) NOT NULL,
	`port_of_entry` INT(11) NOT NULL,
	`vessel_lenght` VARCHAR(255) NOT NULL,
	`vessel_lenght_type` INT(11) NOT NULL,
	`vessel_draft` VARCHAR(255) NOT NULL,
	`vessel_draft_type` INT(11) NOT NULL,
	`max_depth` VARCHAR(255) NOT NULL,
	`visibility` INT(11) NOT NULL,
	`dive_operator_name` VARCHAR(255) NOT NULL,
	`dive_operator_address` VARCHAR(255) NOT NULL,
	`location` VARCHAR(255) NOT NULL,
	`reef_vreak` INT(11) NOT NULL,
	`beach_break` INT(11) NOT NULL,
	`break` INT(11) NOT NULL,
	`swell_hight` VARCHAR(255) NOT NULL,
	`swell_direction` VARCHAR(255) NOT NULL,
	`fuel_price` VARCHAR(255) NOT NULL,
	`point_break` INT(11) NOT NULL,
	`fuel_price_type` INT(11) NOT NULL,
	`water_price` VARCHAR(255) NOT NULL,
	`water_price_type` INT(11) NOT NULL,
	`restaurant` INT(11) NOT NULL,
	`electric_services` INT(11) NOT NULL,
	`electricity_price` VARCHAR(255) NOT NULL,
	`dockage_price` VARCHAR(255) NOT NULL,
	`dockage_price_type` INT(11) NOT NULL,
	`intermediate` INT(11) NOT NULL,
	`how_severe` INT(11) NOT NULL,
	`summary` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pin_id` (`pin_id`),
	CONSTRAINT `FK_pin_fields_user_pins` FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;


");
    }

    public function down()
    {
        echo "m150519_123431_createTablePinField cannot be reverted.\n";

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
