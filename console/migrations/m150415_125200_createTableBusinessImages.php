<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_125200_createTableBusinessImages extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%business_images}}', [
            'id' => Schema::TYPE_PK,
            'image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'business_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_business_images_business_id', '{{%business_images}}', 'business_id');
        $this->createIndex('FK_business_images_image_id', '{{%business_images}}', 'image_id');


        $this->addForeignKey(
            'FK_business_images_image_id', '{{%business_images}}', 'image_id', '{{%images}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%business_images}}');
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
