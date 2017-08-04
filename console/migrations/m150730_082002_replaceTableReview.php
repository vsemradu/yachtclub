<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_082002_replaceTableReview extends Migration
{

    public function up()
    {

        $this->dropForeignKey('FK_review_rating_types_review_id', '{{%review_rating_types}}');
        $this->dropForeignKey('FK_review_business_review_id', '{{%review_business}}');
        $this->dropForeignKey('FK_review_yacht_review_id', '{{%review_yacht}}');

        $this->execute("DROP TABLE IF EXISTS `reviews`;");


        $this->execute("CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) DEFAULT NULL,
  `yacht_id` int(11) DEFAULT NULL,
  `pin_id` int(11) DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `kind_trip` int(11) NOT NULL DEFAULT '0',
  `weather` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sea_swell` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `wind_direction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vessel_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vessel_draft` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vessel_lenght` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vessel_beam` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vessel_air_draft` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vessel_sail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rating_crew` int(11) NOT NULL DEFAULT '0',
  `rating_food` int(11) NOT NULL DEFAULT '0',
  `rating_cleanliness` int(11) NOT NULL DEFAULT '0',
  `rating_enjoyability` int(11) NOT NULL DEFAULT '0',
  `rating_maintenance` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reviews_user_id` (`user_id`),
  KEY `pin_id` (`pin_id`),
  KEY `business_id` (`business_id`),
  KEY `yacht_id` (`yacht_id`),
  CONSTRAINT `FK_reviews_business` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_reviews_user_pins` FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_reviews_yachts` FOREIGN KEY (`yacht_id`) REFERENCES `yachts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");



        $this->addForeignKey(
            'FK_review_rating_types_review_id', '{{%review_rating_types}}', 'review_id', '{{%reviews}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_review_business_review_id', '{{%review_business}}', 'review_id', '{{%reviews}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_review_yacht_review_id', '{{%review_yacht}}', 'review_id', '{{%reviews}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {



        $this->dropTable('{{%reviews}}');
        echo "m150730_082002_replaceTableReview reverted.\n";

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
