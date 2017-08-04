<?php
use yii\db\Schema;
use yii\db\Migration;

class m150420_091535_foreginKeyYachtImages extends Migration
{

    public function up()
    {
        $this->addForeignKey(
            'FK_yacht_images_yacht_yacht_id', '{{%yacht_images}}', 'yacht_id', '{{%yachts}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {
        echo "m150420_091535_foreginKeyYachtImages cannot be reverted.\n";

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
