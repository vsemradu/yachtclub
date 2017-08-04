<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_132138_createTableYachtBlogs extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%yacht_blogs}}', [
            'id' => Schema::TYPE_PK,
            'blog_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'yacht_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_yacht_blogs_blog_id', '{{%yacht_blogs}}', 'blog_id');
        $this->createIndex('FK_yacht_blogs_yacht_id', '{{%yacht_blogs}}', 'yacht_id');

        $this->addForeignKey(
            'FK_yacht_blogs_blog_id', '{{%yacht_blogs}}', 'blog_id', '{{%blog_posts}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%yacht_blogs}}');
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
