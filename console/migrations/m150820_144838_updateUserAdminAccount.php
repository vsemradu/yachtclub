<?php
use yii\db\Schema;
use yii\db\Migration;
use common\models\User;
use common\models\UserInfo;

class m150820_144838_updateUserAdminAccount extends Migration
{
    public function up()
    {
        $model = User::findByEmail('admin@yachtadvisor.com');
        if(!empty($model->id)){
            $model->role = User::ROLE_ADMIN;
            $model->save();
        }
    }

    public function down()
    {
        echo "m150820_144838_updateUserAdminAccount cannot be reverted.\n";

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
