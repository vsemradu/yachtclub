<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_100657_createTableYachtSeason extends Migration
{

    public function up()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `yacht_season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yacht_id` int(11) NOT NULL,
  `season` varchar(255) NOT NULL,
  `from` float DEFAULT NULL,
  `to` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `yacht_id` (`yacht_id`),
  CONSTRAINT `FK_yacht_season_yachts` FOREIGN KEY (`yacht_id`) REFERENCES `yachts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down()
    {

        $this->execute("DROP TABLE IF EXISTS `yacht_season`;");
        echo "m150730_100657_createTableYachtSeason cannot be reverted.\n";

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
