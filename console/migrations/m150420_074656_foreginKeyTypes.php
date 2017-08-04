<?php
use yii\db\Schema;
use yii\db\Migration;

class m150420_074656_foreginKeyTypes extends Migration
{

    public function up()
    {
        $this->addForeignKey(
            'FK_business_types_types_id', '{{%business}}', 'type_id', '{{%types}}', 'id', 'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_yachts_types_types_id', '{{%yachts}}', 'type_id', '{{%types}}', 'id', 'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_review_rating_types_types_types_id', '{{%review_rating_types}}', 'rating_type_id', '{{%types}}', 'id', 'NO ACTION', 'NO ACTION'
        );
//        $this->addForeignKey(
//            'FK_business_types_types_id', '{{%business}}', 'type_id', '{{%types}}', 'id', 'NO ACTION', 'NO ACTION'
//        );
    }

    public function down()
    {
        echo "m150420_074656_foreginKeyTypes cannot be reverted.\n";

        return false;
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
