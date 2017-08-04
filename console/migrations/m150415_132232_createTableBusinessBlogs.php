<?php
use yii\db\Schema;
use yii\db\Migration;

class m150415_132232_createTableBusinessBlogs extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%business_blogs}}', [
            'id' => Schema::TYPE_PK,
            'blog_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'business_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);



        $this->createIndex('FK_business_blogs_blog_id', '{{%business_blogs}}', 'blog_id');
        $this->createIndex('FK_business_blogs_business_id', '{{%business_blogs}}', 'business_id');


        $this->addForeignKey(
            'FK_business_blogs_blog_id', '{{%business_blogs}}', 'blog_id', '{{%blog_posts}}', 'id', 'CASCADE', 'NO ACTION'
        );
    }

    public function down()
    {

        $this->dropTable('{{%business_blogs}}');
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
