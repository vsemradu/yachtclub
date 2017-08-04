<?php
use yii\db\Schema;
use yii\db\Migration;

class m150519_123201_createTablePinImage extends Migration
{

    public function up()
    {
        $this->execute("CREATE TABLE `pin_images` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`pin_id` INT(11) NOT NULL,
	`image_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pin_id` (`pin_id`),
	INDEX `image_id` (`image_id`),
	CONSTRAINT `FK_pin_images_user_pins` FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE,
	CONSTRAINT `FK_pin_images_images` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;
");
    }

    public function down()
    {
        echo "m150519_123201_createTablePinImage cannot be reverted.\n";

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
