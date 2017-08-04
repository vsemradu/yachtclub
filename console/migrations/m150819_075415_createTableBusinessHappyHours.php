<?php
use yii\db\Schema;
use yii\db\Migration;

class m150819_075415_createTableBusinessHappyHours extends Migration
{

    public function up()
    {


        $this->execute("CREATE TABLE `business_happy_hours` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`business_id` INT(11) NOT NULL,
	`week` VARCHAR(50) NULL,
	`special` TEXT NULL,
	INDEX `business_id` (`business_id`),
	PRIMARY KEY (`id`),
	CONSTRAINT `FK__business` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
");
    }

    public function down()
    {
        $this->execute("DROP TABLE `business_happy_hours`;");
        echo "m150819_075415_createTableBusinessHappyHours reverted.\n";

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
