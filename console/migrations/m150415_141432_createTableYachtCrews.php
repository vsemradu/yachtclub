<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_141432_createTableYachtCrews extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%yacht_crews}}', [
            'id' => Schema::TYPE_PK,
            'yacht_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'crew_member_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_yacht_crews_crew_member_id', '{{%yacht_crews}}', 'crew_member_id');

        $this->addForeignKey(
            'FK_yacht_crews_crew_member_id', '{{%yacht_crews}}', 'crew_member_id', '{{%crew_members}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%yacht_crews}}');
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
