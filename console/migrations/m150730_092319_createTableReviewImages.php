<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_092319_createTableReviewImages extends Migration
{

    public function up()
    {
        $this->execute("CREATE TABLE  `review_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `review_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `review_id` (`review_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down()
    {

        $this->execute("DROP TABLE IF EXISTS `review_images`;");
        echo "m150730_092319_createTableReviewImages cannot be reverted.\n";

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
