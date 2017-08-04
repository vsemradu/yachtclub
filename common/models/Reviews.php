<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $business_id
 * @property integer $yacht_id
 * @property integer $pin_id
 * @property string $title
 * @property string $text
 * @property integer $rating
 * @property integer $kind_trip
 * @property string $weather
 * @property string $sea_swell
 * @property string $wind_direction
 * @property string $vessel_name
 * @property string $vessel_draft
 * @property string $vessel_lenght
 * @property string $vessel_beam
 * @property string $vessel_air_draft
 * @property string $vessel_sail
 * @property integer $rating_crew
 * @property integer $rating_food
 * @property integer $rating_cleanliness
 * @property integer $rating_enjoyability
 * @property integer $rating_maintenance
 * @property string $type
 *
 * @property ReviewBusiness[] $reviewBusinesses
 * @property ReviewRatingTypes[] $reviewRatingTypes
 * @property ReviewYacht[] $reviewYachts
 * @property Business $business
 * @property Yachts $yacht
 * @property UserPins $pin
 * @property User $user
 */
class Reviews extends \yii\db\ActiveRecord
{

    protected $userInfoFullName;
    protected $businessBusinessName;
    protected $pinPinFieldName;
    protected $yachtName;

    const KIND_GROUP = 1;
    const KIND_FAMILY = 2;
    const KIND_COUPLE = 3;
    const TYPE_YACHT = 'yacht';
    const TYPE_BUSINESS = 'business';
    const TYPE_PIN = 'pin';
    const APPROVED_FALSE = 0;
    const APPROVED_TRUE = 1;
    const APPROVED_WAITING = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['weather', 'title', 'text', 'sea_swell', 'wind_direction', 'vessel_name', 'vessel_draft', 'vessel_lenght', 'vessel_beam', 'vessel_air_draft', 'vessel_sail', 'type'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['user_id', 'title', 'text', 'type'], 'required'],
            [['kind_trip'], 'required', 'on' => 'pin'],
            [['rating'], 'integer', 'min' => 1],
            [['rating_crew', 'rating_food', 'rating_cleanliness', 'rating_enjoyability', 'rating_maintenance'], 'integer', 'min' => 1, 'on' => 'yacht'],
            [['rating_crew', 'rating_food', 'rating_cleanliness', 'rating_enjoyability', 'rating_maintenance'], 'required', 'on' => 'yacht'],
            [['user_id', 'business_id', 'yacht_id', 'pin_id', 'rating', 'kind_trip', 'rating_crew', 'rating_food', 'rating_cleanliness', 'rating_enjoyability', 'rating_maintenance', 'date_create', 'approved'], 'integer'],
            [['text'], 'string'],
            [['weather', 'title', 'sea_swell', 'wind_direction', 'vessel_name', 'vessel_draft', 'vessel_lenght', 'vessel_beam', 'vessel_air_draft', 'vessel_sail', 'type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('reviews', 'ID'),
            'user_id' => Yii::t('reviews', 'User ID'),
            'business_id' => Yii::t('reviews', 'Business ID'),
            'yacht_id' => Yii::t('reviews', 'Yacht ID'),
            'pin_id' => Yii::t('reviews', 'Pin ID'),
            'title' => Yii::t('reviews', 'Title'),
            'text' => Yii::t('reviews', 'Text'),
            'rating' => Yii::t('reviews', 'Rating'),
            'kind_trip' => Yii::t('reviews', 'Kind Trip'),
            'weather' => Yii::t('reviews', 'Weather'),
            'sea_swell' => Yii::t('reviews', 'Sea Swell'),
            'wind_direction' => Yii::t('reviews', 'Wind Direction'),
            'vessel_name' => Yii::t('reviews', 'Vessel Name'),
            'vessel_draft' => Yii::t('reviews', 'Vessel Draft'),
            'vessel_lenght' => Yii::t('reviews', 'Vessel Lenght'),
            'vessel_beam' => Yii::t('reviews', 'Vessel Beam'),
            'vessel_air_draft' => Yii::t('reviews', 'Vessel Air Draft'),
            'vessel_sail' => Yii::t('reviews', 'Vessel Sail'),
            'rating_crew' => Yii::t('reviews', 'Rating Crew'),
            'rating_food' => Yii::t('reviews', 'Rating Food'),
            'rating_cleanliness' => Yii::t('reviews', 'Rating Cleanliness'),
            'rating_enjoyability' => Yii::t('reviews', 'Rating Enjoyability'),
            'rating_maintenance' => Yii::t('reviews', 'Rating Maintenance'),
            'type' => Yii::t('reviews', 'Type'),
            'date_create' => Yii::t('reviews', 'date_create'),
            'approved' => Yii::t('reviews', 'Approved'),
        ];
    }

    public function getUserInfoFullName()
    {
        return !empty($this->user->userInfo->fullName) ? $this->user->userInfo->fullName : '';
    }

    public function getBusinessBusinessName()
    {
        return !empty($this->business->business_name) ? $this->business->business_name : '';
    }

    public function getPinPinFieldName()
    {
        return !empty($this->pin->pinField->name) ? $this->pin->pinField->name : '';
    }

    public function getYachtName()
    {
        return !empty($this->yacht->name) ? $this->yacht->name : '';
    }

    public function getLittleText()
    {
        return \yii\helpers\StringHelper::truncate($this->text, 150, '...');
    }

    public function getDateCreate()
    {
        return Yii::$app->formatter->asDate($this->date_create);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewBusinesses()
    {
        return $this->hasMany(ReviewBusiness::className(), ['review_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewRatingTypes()
    {
        return $this->hasMany(ReviewRatingTypes::className(), ['review_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewYachts()
    {
        return $this->hasMany(ReviewYacht::className(), ['review_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewReply()
    {
        return $this->hasMany(ReviewReply::className(), ['review_id' => 'id']);
    }

    //TODO: Depending on application structure it should be getReviewImages or hasOne
    public function getReviewImage()
    {
        return $this->hasMany(ReviewImage::className(), ['review_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(Busines::className(), ['id' => 'business_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYacht()
    {
        return $this->hasOne(Yacht::className(), ['id' => 'yacht_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPin()
    {
        return $this->hasOne(UserPin::className(), ['id' => 'pin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTopicUrl()
    {
        if ($this->type == self::TYPE_BUSINESS) {
            return Yii::$app->urlManager->createAbsoluteUrl('/busines/view?id=' . $this->business_id);
        }
        if ($this->type == self::TYPE_PIN) {
            return Yii::$app->urlManager->createAbsoluteUrl('/pin/view?id=' . $this->pin_id);
        }
        if ($this->type == self::TYPE_YACHT) {
            return Yii::$app->urlManager->createAbsoluteUrl('/yacht/view?id=' . $this->yacht_id);
        }
    }
}
