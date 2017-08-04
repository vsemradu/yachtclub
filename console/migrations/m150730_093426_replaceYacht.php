<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_093426_replaceYacht extends Migration
{

    public function up()
    {


        $this->dropForeignKey('FK_yacht_blogs_yacht_id', '{{%yacht_blogs}}');

        $this->dropForeignKey('FK_yacht_crews_yacht_id', '{{%yacht_crews}}');

        $this->dropForeignKey('FK_yacht_images_yacht_yacht_id', '{{%yacht_images}}');
        $this->dropForeignKey('FK_yachts_types_types_id', '{{%yachts}}');
        $this->dropForeignKey('FK_yachts_user_id', '{{%yachts}}');
        $this->dropForeignKey('FK_review_yacht_user_id', '{{%review_yacht}}');
        $this->dropForeignKey('FK_reviews_yachts', '{{%reviews}}');


        $this->execute("DROP TABLE IF EXISTS `yachts`;");
        $this->execute("CREATE TABLE IF NOT EXISTS `yachts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `subtype` int(11) NOT NULL,
  `yacht_type_id` int(11) NOT NULL,
  `yacht_type_two_id` int(11) NOT NULL,
  `yacht_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` int(11) DEFAULT NULL,
  `yacht_build` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `home_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `length` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `beam` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `draft` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `air_draft` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `crew_description` text COLLATE utf8_unicode_ci NOT NULL,
  `background_image_id` int(11) NOT NULL,
  `enable_blog` int(11) DEFAULT '0',
  `share` int(11) NOT NULL,
  `charter_button` int(11) NOT NULL,
  `charter_company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_info` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_yachts_user_id` (`user_id`),
  CONSTRAINT `FK_yachts_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");


        $this->addForeignKey(
            'FK_yacht_blogs_yacht_id', '{{%yacht_blogs}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );

        $this->addForeignKey(
            'FK_yacht_crews_yacht_id', '{{%yacht_crews}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );

        $this->addForeignKey(
            'FK_yacht_images_yacht_yacht_id', '{{%yacht_images}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_yachts_types_types_id', '{{%yachts}}', 'type_id', '{{%types}}', 'id', 'NO ACTION', 'NO ACTION'
        );

       

        $this->addForeignKey(
            'FK_review_yacht_user_id', '{{%review_yacht}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_reviews_yachts', '{{%reviews}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {
        echo "m150730_093426_replaceYacht cannot be reverted.\n";

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
