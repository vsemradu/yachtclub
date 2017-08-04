<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_114622_createTableUserPins extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_pins}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lat' => Schema::TYPE_STRING . '(255) NOT NULL',
            'lan' => Schema::TYPE_STRING . '(255) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'approved' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);

        $this->addForeignKey(
            'FK_user_pins_user_id_user', '{{%user_pins}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'FK_user_pins_user_id_user', '{{%user_pins}}'
        );
        $this->dropTable('{{%user_pins}}');
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
