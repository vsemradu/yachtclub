<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_134048_createTableReviewRatingTypes extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%review_rating_types}}', [
            'id' => Schema::TYPE_PK,
            'review_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rating_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_review_rating_types_review_id', '{{%review_rating_types}}', 'review_id');
        $this->createIndex('FK_review_rating_types_rating_type_id', '{{%review_rating_types}}', 'rating_type_id');


        $this->addForeignKey(
            'FK_review_rating_types_review_id', '{{%review_rating_types}}', 'review_id', '{{%reviews}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_review_rating_types_rating_type_id', '{{%review_rating_types}}', 'rating_type_id', '{{%rating_types}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%review_rating_types}}');
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
