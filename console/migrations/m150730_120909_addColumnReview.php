<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_120909_addColumnReview extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `reviews` ADD COLUMN `title` VARCHAR(255) NOT NULL AFTER `pin_id`;");
    }

    public function down()
    {

         $this->execute("ALTER TABLE `reviews` 	DROP COLUMN `title`;");
        echo "m150730_120909_addColumnReview reverted.\n";

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
