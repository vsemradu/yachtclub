<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_130740_createTableYachtImages extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%yacht_images}}', [
            'id' => Schema::TYPE_PK,
            'yacht_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);




        $this->createIndex('FK_yacht_images_yacht_id', '{{%yacht_images}}', 'yacht_id');
        $this->createIndex('FK_yacht_images_image_id', '{{%yacht_images}}', 'image_id');

        $this->addForeignKey(
            'FK_yacht_images_image_id', '{{%yacht_images}}', 'image_id', '{{%images}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%yacht_images}}');
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
