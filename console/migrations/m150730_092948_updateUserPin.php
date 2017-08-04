<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_092948_updateUserPin extends Migration
{

    public function up()
    {
        
        
          $this->execute("ALTER TABLE `user_pins`	DROP COLUMN `title`;");
          $this->execute("ALTER TABLE `user_pins`	CHANGE COLUMN `lat` `lat` DECIMAL(20,10) NOT NULL;");
          $this->execute("ALTER TABLE `user_pins`	CHANGE COLUMN `lan` `lan` DECIMAL(20,10) NOT NULL;");
      
    }

    public function down()
    {
        echo "m150730_092948_updateUserPin cannot be reverted.\n";

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
