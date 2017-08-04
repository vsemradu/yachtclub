<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_131503_createTableBlogPosts extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%blog_posts}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'type' => Schema::TYPE_STRING . '(255) NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_blog_posts_user_id', '{{%blog_posts}}', 'user_id');
        $this->createIndex('FK_blog_posts_image_id', '{{%blog_posts}}', 'image_id');
        $this->addForeignKey(
            'FK_blog_posts_user_user_id', '{{%blog_posts}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION'
        );

        $this->addForeignKey(
            'FK_blog_posts_user_image_id', '{{%blog_posts}}', 'image_id', '{{%images}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%blog_posts}}');
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
