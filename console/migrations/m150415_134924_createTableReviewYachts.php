<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_134924_createTableReviewYachts extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%review_yacht}}', [
            'id' => Schema::TYPE_PK,
            'review_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'yacht_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_review_yacht_review_id', '{{%review_yacht}}', 'review_id');
        $this->addForeignKey(
            'FK_review_yacht_review_id', '{{%review_yacht}}', 'review_id', '{{%reviews}}', 'id', 'CASCADE', 'NO ACTION'
        );


       
    }

    public function down()
    {

        $this->dropTable('{{%review_yacht}}');
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
