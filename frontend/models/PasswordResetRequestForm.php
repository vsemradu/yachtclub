<?php namespace frontend\models;

use common\models\User;
use yii\base\Model;
use yii\helpers\Url;
use yii\helpers\Html;
/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {




                return \Yii::$app->mailer->compose()
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setTo($user->email)
                        ->setSubject('Password reset')
                        ->setHtmlBody('Hello,<br><br>To reset your Yacht Advisor password, simply click the '.Html::a('link', Url::toRoute(['/site/reset-password', 'token' => $user->password_reset_token])).' below. That will take you to a web page where you can create a new password. <br><br>Please note, for your security the link will expire one hour after this email was sent.If you need help or have any comments or suggestions, please reply to this email.<br>Sincerely,The Crew at Yacht Advisor ')
                        ->send();


//                return \Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
//                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
//                        ->setTo($this->email)
//                        ->setSubject('Password reset for ' . \Yii::$app->name)
//                        ->send();
            }
        }

        return false;
    }
}
