<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_093030_createTableUserInfo extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_infos}}', [
            'id' => Schema::TYPE_PK,
            'image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'location' => Schema::TYPE_TEXT . ' NOT NULL',
            'first_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'last_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_user_user_id', '{{%user_infos}}', 'user_id');
        $this->createIndex('FK_user_image_id', '{{%user_infos}}', 'image_id');
        $this->addForeignKey(
            'FK_user_infos_user_id_user', '{{%user_infos}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropTable('{{%user_infos}}');
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
