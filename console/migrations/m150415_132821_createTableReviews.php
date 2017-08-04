<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_132821_createTableReviews extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%reviews}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'weather_info' => Schema::TYPE_STRING . '(255) NOT NULL',
            'boat_info' => Schema::TYPE_TEXT . ' NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_reviews_user_id', '{{%reviews}}', 'user_id');

        $this->addForeignKey(
            'FK_reviews_user_id', '{{%reviews}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%reviews}}');
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
