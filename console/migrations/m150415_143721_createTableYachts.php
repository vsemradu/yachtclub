<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_143721_createTableYachts extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%yachts}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type' => Schema::TYPE_STRING . '(255) NOT NULL',
            'subtype' => Schema::TYPE_STRING . '(255) NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'year' => Schema::TYPE_INTEGER . ' NOT NULL',
            'yacht_build' => Schema::TYPE_STRING . '(255) NOT NULL',
            'home_port' => Schema::TYPE_STRING . '(255) NOT NULL',
            'length' => Schema::TYPE_STRING . '(255) NOT NULL',
            'beam' => Schema::TYPE_STRING . '(255) NOT NULL',
            'draft' => Schema::TYPE_STRING . '(255) NOT NULL',
            'air_draft' => Schema::TYPE_STRING . '(255) NOT NULL',
            'website' => Schema::TYPE_STRING . '(255) NOT NULL',
            'summary' => Schema::TYPE_STRING . '(255) NOT NULL',
            'background_image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'enable_blog' => Schema::TYPE_STRING . '(255) NOT NULL',
            'charter_company' => Schema::TYPE_STRING . '(255) NOT NULL',
            'contact_info' => Schema::TYPE_STRING . '(255) NOT NULL',
            ], $tableOptions);



        $this->createIndex('FK_yachts_user_id', '{{%yachts}}', 'user_id');
        $this->createIndex('FK_yacht_crews_yacht_id', '{{%yacht_crews}}', 'yacht_id');


        $this->addForeignKey(
            'FK_yachts_user_id', '{{%yachts}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_yacht_crews_yacht_id', '{{%yacht_crews}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );

        $this->addForeignKey(
            'FK_yacht_blogs_yacht_id', '{{%yacht_blogs}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );

        $this->createIndex('FK_review_yacht_yacht_id', '{{%review_yacht}}', 'yacht_id');

        $this->addForeignKey(
            'FK_review_yacht_user_id', '{{%review_yacht}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%yachts}}');
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
