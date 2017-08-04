<?php
use yii\db\Schema;
use yii\db\Migration;

class m150828_075046_insertCrewRole extends Migration
{

    public function up()
    {

        $this->execute("TRUNCATE `crew_member_roles`;");
        $this->execute("INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Captain ', 1);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('1st Mate ', 2);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Bosun ', 3);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Lead Deckhand ', 4);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Deckhand ', 5);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Captain/Engineer ', 6);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Chief Engineer ', 7);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('2nd Engineer ', 8);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Chef ', 9);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Sous Chef ', 10);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Chief Stewardess ', 11);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('2nd Stewardess ', 12);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('3rd Stewardess ', 13);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Chef/Hostess ', 14);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Stewardess ', 15);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Deck/Stew ', 16);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Stew/Masseuse', 17);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Stew/Dive Instructor', 18);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Dive Instructor ', 19);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Galley Slave ', 20);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Galley Wench ', 21);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Dishwasher ', 22);
INSERT INTO `crew_member_roles` (`name`, `sort`) VALUES ('Bilge Cleaner', 23);
");
    }

    public function down()
    {
        $this->execute("TRUNCATE `crew_member_roles`;");

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
