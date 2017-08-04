<?php namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const REG_TYPE_FB = 2;
    const REG_TYPE_FRONTENT = 1;

    public $old_password;
    public $password;
    public $confirm_password;
    public $termsCondition;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE, 'on' => ['insert_fb']],
            ['status', 'default', 'value' => self::STATUS_DELETED, 'on' => ['insert']],
            [['email', 'username'], 'string', 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            [['email'], 'required', 'on' => ['insert', 'insert_fb', 'update']],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => \Yii::t('user', 'This email address has already been taken.')],
            [['password', 'confirm_password', 'old_password'], 'filter', 'filter' => 'trim'],
            [['password', 'confirm_password'], 'required', 'on' => ['insert', 'update_password']],
            [['old_password'], 'required', 'on' => ['update_password']],
            [['password', 'confirm_password', 'old_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'on' => ['insert', 'update_password']],
            ['termsCondition', 'compare', 'compareValue' => 0, 'operator' => '!=', 'message' => \Yii::t('user', 'You must accept Terms&Conditions.'), 'on' => ['insert']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => \Yii::t('user', 'Username'),
            'email' => \Yii::t('user', 'Email'),
            'password' => \Yii::t('user', 'Password'),
            'confirm_password' => \Yii::t('user', 'Confirm Password'),
            'old_password' => \Yii::t('user', 'Old Password'),
            'termsCondition' => \Yii::t('user', 'Terms Condition'),
        ];
    }

    public function registrationEmail()
    {

        $this->code_confirm = uniqid();
        $this->save();
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject('Nautic Nomad')
            ->setHtmlBody('Dear ' . $this->userInfo->fullName . ',<br><br>Thank you for joining us! Please follow the link below to confirm your registration<br><br><a href="' . \Yii::$app->urlManager->createUrl(['/site/confirm/', 'code' => $this->code_confirm]) . '">' . \Yii::$app->urlManager->createUrl(['/site/confirm/', 'code' => $this->code_confirm]) . '</a><br><br>Nautic Nomad team')
            ->send();
    }

    public function updateEmail()
    {
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->oldAttributes['email'])
            ->setSubject('Nautic Nomad')
            ->setHtmlBody('Hello ' . $this->userInfo->fullName . ',<br><br>Your email  has been successfully changed. If you didn\'t initiate this process, please contact us at ' . Yii::$app->params['adminEmail'] . ' for further assistance.<br><br>Nautic Nomad team')
            ->send();
    }

    public function updatePasswordEmail()
    {
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject('Nautic Nomad')
            ->setHtmlBody('Hello ' . $this->userInfo->fullName . ',<br><br>Your password  has been successfully changed. If you didn\'t initiate this process, please contact us at ' . Yii::$app->params['adminEmail'] . ' for further assistance.<br><br>Nautic Nomad team')
            ->send();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByFbId($id)
    {
        return static::findOne(['fb_id' => $id]);
    }

    public static function findByCodeConfirm($code)
    {
        return static::findOne(['code_confirm' => $code]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                'password_reset_token' => $token,
                'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'id']);
    }

    public function getUserBusines()
    {
        return $this->hasMany(Busines::className(), ['user_id' => 'id']);
    }

    public function getUserYacht()
    {
        return $this->hasMany(Yacht::className(), ['user_id' => 'id']);
    }

    //TODO: Add (s) getUserPins.
    public function getUserPin()
    {
        return $this->hasMany(UserPin::className(), ['user_id' => 'id']);
    }
    public function getUserReview()
    {
        return $this->hasMany(Reviews::className(), ['user_id' => 'id']);
    }

    public function getUserPages()
    {

        $data = [];
        foreach ($this->userBusines as $userBusines) {
            $data[$userBusines->date_create]['data'] = $userBusines;
            $data[$userBusines->date_create]['type'] = 'busines';
        }
        foreach ($this->userYacht as $userYacht) {
            $data[$userYacht->date_create]['data'] = $userYacht;
            $data[$userYacht->date_create]['type'] = 'yacht';
        }
        krsort($data);
        return $data;
    }

    public function getUserPageCount()
    {
        //TODO: Use ActiveQuery ->count() instead of PHP count(..)

        return count($this->userBusines) + count($this->userYacht);
    }

    public static function hasBackendAccess()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        $user = self::findOne([Yii::$app->user->id]);
        return ($user->role == self::ROLE_ADMIN) ? true : false;
    }
}
