<?php
use yii\db\Schema;
use yii\db\Migration;

class m150603_110620_updateBuisinessImageFonAdd extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `business`
	ADD COLUMN `image_id` INT(11) NOT NULL AFTER `private`;");
    }

    public function down()
    {
        echo "m150603_110620_updateBuisinessImageFonAdd cannot be reverted.\n";

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
