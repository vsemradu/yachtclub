<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_101822_deleteForeenKeyYachType extends Migration
{

    public function up()
    {
        $this->dropForeignKey('FK_yachts_types_types_id', '{{%yachts}}');
    }

    public function down()
    {
        echo "m150730_101822_deleteForeenKeyYachType cannot be reverted.\n";

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
