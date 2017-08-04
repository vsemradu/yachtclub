<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_131955_createTableBlogPostComments extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%blog_post_comments}}', [
            'id' => Schema::TYPE_PK,
            'blog_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            ], $tableOptions);


        $this->createIndex('FK_blog_post_comments_images_blog_id', '{{%blog_post_comments}}', 'blog_id');
        $this->createIndex('FK_blog_post_comments_images_user_id', '{{%blog_post_comments}}', 'user_id');


        $this->addForeignKey(
            'FK_blog_post_comments_images_blog_id', '{{%blog_post_comments}}', 'blog_id', '{{%blog_posts}}', 'id', 'CASCADE', 'NO ACTION'
        );
        $this->addForeignKey(
            'FK_blog_post_comments_images_user_id', '{{%blog_post_comments}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%blog_post_comments}}');
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
