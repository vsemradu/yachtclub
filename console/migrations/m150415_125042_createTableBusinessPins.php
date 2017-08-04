<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_125042_createTableBusinessPins extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%business_pins}}', [
            'id' => Schema::TYPE_PK,
            'pin_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'business_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);

        $this->createIndex('FK_business_pins_business_id', '{{%business_pins}}', 'business_id');
        $this->createIndex('FK_business_pins_pin_id', '{{%business_pins}}', 'pin_id');
    }

    public function down()
    {

        $this->dropTable('{{%business_pins}}');
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
