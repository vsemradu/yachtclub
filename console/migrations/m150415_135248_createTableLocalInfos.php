<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_135248_createTableLocalInfos extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%local_infos}}', [
            'id' => Schema::TYPE_PK,
            'country' => Schema::TYPE_STRING . '(255) NOT NULL',
            'type' => Schema::TYPE_STRING . '(255) NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            ], $tableOptions);
    }

    public function down()
    {

        $this->dropTable('{{%local_infos}}');
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
