<?php
use yii\db\Schema;
use yii\db\Migration;

class m150602_113003_updateBuisinessRatingAdd extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `business`
	ADD COLUMN `rating` INT(11) NOT NULL DEFAULT '0' AFTER `id`;");
    }

    public function down()
    {
        echo "m150602_113003_updateBuisinessRatingAdd cannot be reverted.\n";

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
