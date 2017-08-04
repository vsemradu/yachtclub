<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "user_infos".
 *
 * @property integer $id
 * @property integer $image_id
 * @property integer $user_id
 * @property string $location
 * @property string $first_name
 * @property string $last_name
 *
 * @property Images $image
 * @property User $user
 */
class UserInfo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_infos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['first_name', 'last_name', 'location'], 'filter', 'filter' => function($value) {
                    return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
                }],
                [['first_name', 'last_name'], 'required', 'on' => ['insert', 'insert_fb', 'update']],
                [['image_id', 'user_id'], 'integer'],
                [['location'], 'string'],
                [['first_name', 'last_name'], 'string', 'max' => 255],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'image_id' => \Yii::t('user', 'Image ID'),
                'user_id' => \Yii::t('user', 'User ID'),
                'location' => \Yii::t('user', 'Location'),
                'first_name' => \Yii::t('user', 'First Name'),
                'last_name' => \Yii::t('user', 'Last Name'),
            ];
        }

        public function getFullName()
        {
            return $this->first_name . ' ' . $this->last_name;
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getImage()
        {
            return $this->hasOne(Image::className(), ['id' => 'image_id']);
        }

        public function getImageUrl()
        {
            if (!empty($this->image_id)) {
                //TODO: Change to @frontend alias instead
                return Yii::$app->urlManager->createAbsoluteUrl('../frontend/web/uploads/' . $this->image->name);
            }
            return;
        }
      

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getUser()
        {
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }
    }
    
