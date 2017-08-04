<?php namespace common\models;

use Yii;
use common\models\UserPin;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "business".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type_id
 * @property integer $owner
 * @property string $business_name
 * @property string $address
 * @property string $phone
 * @property string $website
 * @property string $summary
 * @property string $private
 *
 * @property Types $type
 * @property User $user
 * @property BusinessBlogs[] $businessBlogs
 * @property BusinessImages[] $businessImages
 * @property BusinessPins[] $businessPin
 * @property ReviewBusiness[] $reviewBusinesses
 */
class Busines extends \yii\db\ActiveRecord
{
    protected $businessName;
    public $pin_id;

    const TYPE_MARINA = 1;
    const TYPE_CHANDLERY = 2;
    const TYPE_FLOWERS = 3;
    const TYPE_LIQUOR = 4;
    const TYPE_PROVISIONS = 5;
    const TYPE_REPAIRS = 6;
    const TYPE_TOURS = 7;
    const TYPE_PORT = 8;
    const TYPE_RESTAURANTS = 9;
    const TYPE_LAUNDRY = 10;
    const TYPE_DIVING = 11;
    const TYPE_FUEL = 12;
    const TYPE_HOTELS = 13;
    const TYPE_TRANSPORTATION = 14;
    const TYPE_FISHING = 15;
    const TYPE_OTHER = 16;
    const OWN_TRUE = 1;
    const OWN_FALSE = 2;
    const PRIVATE_TRUE = 1;
    const PRIVATE_FALSE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type_id', 'owner', 'business_name', 'phone', 'website', 'summary', 'private', 'type_text'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['website'], 'url', 'defaultScheme' => 'http'],
            [['user_id', 'type_id', 'owner', 'business_name'], 'required'],
            [['user_id', 'type_id', 'owner', 'rating'], 'integer'],
            [['address', 'pin_id'], 'string'],
            [['business_name', 'phone', 'website', 'summary', 'private', 'type_text'], 'string', 'max' => 255],
            ['date_create', 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('business', 'ID'),
            'user_id' => Yii::t('business', 'User ID'),
            'type_id' => Yii::t('business', 'Type ID'),
            'type_text' => Yii::t('business', 'Type text'),
            'owner' => Yii::t('business', 'Owner'),
            'business_name' => Yii::t('business', 'Business Name'),
            'address' => Yii::t('business', 'Address'),
            'phone' => Yii::t('business', 'Phone'),
            'website' => Yii::t('business', 'Website'),
            'summary' => Yii::t('business', 'Summary'),
            'private' => Yii::t('business', 'Private'),
            'pin_id' => Yii::t('business', 'Pin'),
            'rating' => Yii::t('business', 'Rating'),
        ];
    }
    
    
        public function getBusinessName()
    {
        return \yii\helpers\Html::a($this->business_name, \yii\helpers\Url::to('../../busines/view?id=' . $this->id), ['target' => '_blank']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAverageRating()
    {
        $rating = $this->rating;
        foreach ($this->reviewBusineses as $reviewBusineses) {
            $rating = $rating + $reviewBusineses->rating;
        }

        if (empty($rating)) {
            return 0;
        } else {
            return ($rating / (count($this->reviewBusineses) + 1));
        }
    }

    public function happyHourByWeek($week)
    {
        
        return $this->hasMany(BusinessHappyHour::className(), ['business_id' => 'id'])->where(['week'=>$week]);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOwnerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessHappyHour()
    {
        return $this->hasMany(BusinessHappyHour::className(), ['business_id' => 'id']);
    }
    public function getBusinessBlogs()
    {
        return $this->hasMany(BusinessBlogs::className(), ['business_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessImages()
    {
        return $this->hasMany(BusinessImage::className(), ['business_id' => 'id']);
    }

    public function getBusinessImageFon()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessPin()
    {
        return $this->hasOne(BusinessPin::className(), ['business_id' => 'id']);
    }

    public function getPin()
    {
        return $this->hasOne(UserPin::className(), ['id' => 'pin_id'])->via('businessPin');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewBusineses()
    {
        return $this->hasMany(Reviews::className(), ['business_id' => 'id']);
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'type_title' => array(
                self::TYPE_MARINA => Yii::t('business', 'Marina / Yacht Club'),
                self::TYPE_CHANDLERY => Yii::t('business', 'Chandlery'),
                self::TYPE_FLOWERS => Yii::t('business', 'Flowers'),
                self::TYPE_LIQUOR => Yii::t('business', 'Liquor / Wine Store'),
                self::TYPE_PROVISIONS => Yii::t('business', 'Provisions / Groceries'),
                self::TYPE_REPAIRS => Yii::t('business', 'Repairs / Refit'),
                self::TYPE_TOURS => Yii::t('business', 'Tours / Activities'),
                self::TYPE_PORT => Yii::t('business', 'Port of Entry'),
                self::TYPE_RESTAURANTS => Yii::t('business', 'Restaurants / Bars'),
                self::TYPE_LAUNDRY => Yii::t('business', 'Laundry Services / Dryclean'),
                self::TYPE_DIVING => Yii::t('business', 'Diving'),
                self::TYPE_FUEL => Yii::t('business', 'Fuel'),
                self::TYPE_HOTELS => Yii::t('business', 'Hotels / Resorts'),
                self::TYPE_TRANSPORTATION => Yii::t('business', ' Transportation <sm>(Taxi, Ferries, Car Hire)</sm>'),
                self::TYPE_FISHING => Yii::t('business', 'Fishing'),
                self::TYPE_OTHER => Yii::t('business', 'Other'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public static function getBusinessesByArea($ne_lat, $sw_lat, $ne_lng, $sw_lng)
    {

        $models = self::find()
            ->joinWith(['pin'], true, 'INNER JOIN')
            ->andWhere(['between', UserPin::tableName() . '.lat', $sw_lat, $ne_lat])
            ->andWhere(['between', UserPin::tableName() . '.lan', $sw_lng, $ne_lng])
            ->all();

        return ArrayHelper::map($models, 'id', 'business_name');
    }

    public static function getBusinessesByAreaType($ne_lat, $sw_lat, $ne_lng, $sw_lng, $type_id, $ret = 'array')
    {

        $models = self::find()
            ->joinWith(['pin'], true, 'INNER JOIN')
            ->andWhere(['between', UserPin::tableName() . '.lat', $sw_lat, $ne_lat])
            ->andWhere(['between', UserPin::tableName() . '.lan', $sw_lng, $ne_lng])
            ->andWhere([Busines::tableName() . '.type_id' => $type_id])
            ->all();
        if ($ret == 'array') {
            return ArrayHelper::map($models, 'id', 'business_name');
        }

        if ($ret == 'list') {
            return $models;
        }
    }
}
