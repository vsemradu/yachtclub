<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_100844_updateBlogPost extends Migration
{

    public function up()
    {

        $this->execute("ALTER TABLE `blog_posts`
	CHANGE COLUMN `user_id` `user_id` INT(11) NULL DEFAULT NULL AFTER `id`,
	CHANGE COLUMN `image_id` `image_id` INT(11) NULL DEFAULT NULL AFTER `user_id`;");
    }

    public function down()
    {

        $this->execute("ALTER TABLE `blog_posts`
	CHANGE COLUMN `user_id` `user_id` INT(11) NOT NULL AFTER `id`,
	CHANGE COLUMN `image_id` `image_id` INT(11) NOT NULL AFTER `user_id`;");
        echo "m150730_100844_updateBlogPost cannot be reverted.\n";

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
