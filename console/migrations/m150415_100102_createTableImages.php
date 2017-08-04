<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_100102_createTableImages extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%images}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            ], $tableOptions);

        $this->addForeignKey(
            'FK_user_infos_image_id_user', '{{%user_infos}}', 'image_id', '{{%images}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'FK_user_infos_image_id_user', '{{%images}}'
        );
        $this->dropTable('{{%images}}');
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
