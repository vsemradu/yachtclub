<?php

use yii\db\Schema;
use yii\db\Migration;

class m150730_075211_addCrewMembersPhotoColumn extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `crew_members` ADD COLUMN `photo_id` INT(11) DEFAULT NULL AFTER `name`;");
    }

    public function down()
    {

        $this->execute("ALTER TABLE `crew_members` 	DROP COLUMN `photo_id`;");

        echo "m150730_075211_addCrewMembersPhotoColumn reverted.\n";

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
