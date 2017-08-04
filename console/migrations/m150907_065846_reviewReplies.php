<?php
use yii\db\Schema;
use yii\db\Migration;

class m150907_065846_reviewReplies extends Migration
{

    public function up()
    {
        $this->execute("CREATE TABLE `review_replies` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`review_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`text` TEXT NOT NULL,
	`type` VARCHAR(255) NOT NULL,
	`date_create` INT(11) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `review_id` (`review_id`),
	INDEX `user_id` (`user_id`),
	CONSTRAINT `FK_review_replies_reviews` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE,
	CONSTRAINT `FK_review_replies_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
");
    }

    public function down()
    {
        $this->execute("DROP TABLE `review_replies`;");

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
