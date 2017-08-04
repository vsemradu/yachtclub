<?php
use yii\db\Schema;
use yii\db\Migration;

class m150730_075802_replaceTableLocalInfo extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->dropTable('{{%local_infos}}');


        $this->createTable('{{%local_infos}}', [
            'id' => Schema::TYPE_PK,
            'location_lat' => Schema::TYPE_STRING . '(255) NOT NULL',
            'location_lng' => Schema::TYPE_STRING . '(255) NOT NULL',
            'zoom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'area_box_ne_lat' => Schema::TYPE_STRING . '(255) NOT NULL',
            'area_box_sw_lat' => Schema::TYPE_STRING . '(255) NOT NULL',
            'area_box_ne_lng' => Schema::TYPE_STRING . '(255) NOT NULL',
            'area_box_sw_lng' => Schema::TYPE_STRING . '(255) NOT NULL',
            'area_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'type_of_address' => Schema::TYPE_STRING . '(255) NOT NULL',
            'summary' => Schema::TYPE_TEXT . ' NOT NULL',
            'customs_immigrations' => Schema::TYPE_TEXT . ' NOT NULL',
            'marine_laws_regulations' => Schema::TYPE_TEXT . ' NOT NULL',
            'local_life' => Schema::TYPE_TEXT . ' NOT NULL',
            'image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'featured_business_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'local_life_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_local_infos_image_image_id', '{{%local_infos}}', 'image_id');
    }

    public function down()
    {

        $this->dropTable('{{%local_infos}}');
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
