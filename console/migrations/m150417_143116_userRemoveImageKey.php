<?php
use yii\db\Schema;
use yii\db\Migration;

class m150417_143116_userRemoveImageKey extends Migration
{

    public function up()
    {
        $this->dropForeignKey('FK_user_infos_image_id_user', '{{%user_infos}}');
    }

    public function down()
    {
        echo "m150417_143116_userRemoveImageKey cannot be reverted.\n";

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
