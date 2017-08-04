<?php
use yii\db\Schema;
use yii\db\Migration;

class m150817_062714_addColumnCurrencyYachtSeason extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `yacht_season` ADD COLUMN `currency` VARCHAR(3) NOT NULL AFTER `to`;");
    }

    public function down()
    {

        $this->execute("ALTER TABLE `yacht_season`	DROP COLUMN `currency`;");

        echo "m150817_062714_addColumnCurrencyYachtSeason reverted.\n";

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
