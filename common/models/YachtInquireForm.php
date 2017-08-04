<?php namespace common\models;

use Yii;
use yii\base\Model;

class YachtInquireForm extends Model
{

    public $phone;
    public $email;
    public $message;
    public $verifyCode;
    public $people;
    public $date_start;
    public $date_end;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'email', 'message'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['email', 'date_start', 'date_end'], 'string', 'max' => 255],
            [['phone'], 'integer'],
            [['people'], 'integer', 'min' => 1],
            [['phone', 'email', 'message'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha', 'when' => function ($model) {
                    if (empty(\Yii::$app->user->id)) {
                        return true;
                    } else {
                        return false;
                    }
                },],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date_end' => 'Date end',
            'date_start' => 'Date start',
            'people' => 'People count',
            'phone' => 'Phone',
            'email' => 'Email',
            'message' => 'Message',
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail()
    {
        return Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo(Yii::$app->params['adminEmail'])
                ->setSubject('Yacht Inquiry')
                ->setHtmlBody('<b>Email:</b> ' . $this->email . ',<br><b>Phone:</b> ' . $this->phone . '<br><b>People count:</b> ' . $this->people . '<br><b>Date start - date end:</b> ' . $this->date_start . ' - ' . $this->date_end . '<br><br><b>Message:</b> ' . $this->message)
                ->send();
    }
}
