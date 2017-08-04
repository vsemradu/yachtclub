<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_140047_createTableBusinessTypes extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%business_types}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            ], $tableOptions);


        $this->addForeignKey(
            'FK_business_types_user_user_id', '{{%business}}', 'type_id', '{{%business_types}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%business_types}}');
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
