<?php
use yii\db\Schema;
use yii\db\Migration;

class m150420_065018_dropTableTypes extends Migration
{

    public function up()
    {


        $this->dropForeignKey('FK_business_types_user_user_id', '{{%business}}');
        $this->dropForeignKey('FK_review_rating_types_rating_type_id', '{{%review_rating_types}}');


        $this->dropTable('{{%yacht_types}}');
        $this->dropTable('{{%business_types}}');
        $this->dropTable('{{%rating_types}}');
    }

    public function down()
    {
        echo "m150420_065018_dropTableTypes cannot be reverted.\n";

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
