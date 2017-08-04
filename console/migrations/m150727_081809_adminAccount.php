<?php
use yii\db\Schema;
use yii\db\Migration;
use common\models\User;
use common\models\UserInfo;

class m150727_081809_adminAccount extends Migration
{

    public function up()
    {
        $model = new User();
        $modelInfo = new UserInfo();
        $model->scenario = 'insert';
        $modelInfo->scenario = 'insert';

        $model->email = 'admin@yachtadvisor.com';
        $model->password = '123456';
        $model->confirm_password = '123456';
        $model->role = User::ROLE_USER;
        $model->reg_type = \common\models\User::REG_TYPE_FRONTENT;
        $model->status = User::STATUS_ACTIVE;
        $modelInfo->first_name = 'admin';
        $modelInfo->last_name = 'admin';

        $model->validate();
        $modelInfo->validate();

        $model->setPassword($model->password);
        $model->generateAuthKey();

        if ($model->save()) {
            $modelInfo->user_id = $model->id;
            $modelInfo->save();
        }
        
        print_r($modelInfo->getErrors());
        print_r($model->getErrors());
    }

    public function down()
    {
        
        $model = User::findByEmail('admin@yachtadvisor.com');
        if(!empty($model->id)){
            $model->delete();
        }
        echo "m150727_081809_adminAccount reverted.\n";

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
