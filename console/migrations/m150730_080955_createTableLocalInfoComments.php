<?php
use yii\db\Schema;
use yii\db\Migration;


class m150730_080955_createTableLocalInfoComments extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }



        $this->createTable('{{%local_info_comments}}', [
            'id' => Schema::TYPE_PK,
            'local_info_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rate' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date_create' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);

        $this->createIndex('FK_local_info_comments_local_info_local_info_id', '{{%local_info_comments}}', 'local_info_id');

        $this->createIndex('FK_local_info_comments_user_user_id', '{{%local_info_comments}}', 'user_id');


        $this->addForeignKey(
            'FK_local_info_comments_local_info_local_info_id', '{{%local_info_comments}}', 'local_info_id', '{{%local_infos}}', 'id', 'CASCADE', 'NO ACTION'
        );

        $this->addForeignKey(
            'FK_local_info_comments_user_user_id', '{{%local_info_comments}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%local_info_comments}}');
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
