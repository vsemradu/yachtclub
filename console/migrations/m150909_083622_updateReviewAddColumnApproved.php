<?php

use yii\db\Schema;
use yii\db\Migration;

class m150909_083622_updateReviewAddColumnApproved extends Migration
{
    public function up()
    {
          $this->execute("ALTER TABLE `reviews`	ADD COLUMN `approved` INT(11) NOT NULL DEFAULT '0' AFTER `date_create`;");
    }

    public function down()
    {
         $this->execute("ALTER TABLE `reviews`	DROP COLUMN `approved`;");

        return true;
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
