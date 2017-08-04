<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_080438_createTableLocalInfoBusiness extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }



        $this->createTable('{{%local_info_business}}', [
            'id' => Schema::TYPE_PK,
            'local_info_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'business_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type' => Schema::TYPE_STRING . '(255) NOT NULL',
            ], $tableOptions);

        $this->createIndex('FK_local_info_business_local_info_local_info_id', '{{%local_info_business}}', 'local_info_id');

        $this->createIndex('FK_local_info_business_business_business_id', '{{%local_info_business}}', 'business_id');


        $this->addForeignKey(
            'FK_local_info_business_local_info_local_info_id', '{{%local_info_business}}', 'local_info_id', '{{%local_infos}}', 'id', 'CASCADE', 'NO ACTION'
        );

        $this->addForeignKey(
            'FK_local_info_business_business_business_id', '{{%local_info_business}}', 'business_id', '{{%business}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%local_info_business}}');
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
