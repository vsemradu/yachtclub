<?php
use yii\db\Schema;
use yii\db\Migration;

class m150529_072637_deleteBuisinessKey extends Migration
{

    public function up()
    {
        $this->execute("ALTER TABLE `business`
	DROP INDEX `FK_business_type_id`,
	DROP FOREIGN KEY `FK_business_types_types_id`;");
    }

    public function down()
    {
        echo "m150529_072637_deleteBuisinessKey cannot be reverted.\n";

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
