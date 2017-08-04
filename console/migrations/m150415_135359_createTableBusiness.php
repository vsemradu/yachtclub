<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_135359_createTableBusiness extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%business}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'owner' => Schema::TYPE_INTEGER . ' NOT NULL',
            'business_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'address' => Schema::TYPE_TEXT . ' NOT NULL',
            'phone' => Schema::TYPE_STRING . '(255) NOT NULL',
            'website' => Schema::TYPE_STRING . '(255) NOT NULL',
            'summary' => Schema::TYPE_STRING . '(255) NOT NULL',
            'private' => Schema::TYPE_STRING . '(255) NOT NULL',
            ], $tableOptions);



        $this->createIndex('FK_business_user_id', '{{%business}}', 'user_id');
        $this->createIndex('FK_business_type_id', '{{%business}}', 'type_id');
        $this->addForeignKey(
            'FK_business_user_user_id', '{{%business}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_business_pins_business_user_id', '{{%business_pins}}', 'business_id', '{{%business}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_business_images_business_user_id', '{{%business_images}}', 'business_id', '{{%business}}', 'id', 'CASCADE', 'NO ACTION'
        );

        $this->addForeignKey(
            'FK_business_blogs_business_id', '{{%business_blogs}}', 'business_id', '{{%business}}', 'id', 'CASCADE', 'NO ACTION'
        );



        $this->createIndex('FK_review_business_business_id', '{{%review_business}}', 'business_id');
        $this->addForeignKey(
            'FK_review_business_business_id', '{{%review_business}}', 'business_id', '{{%business}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%business}}');
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
