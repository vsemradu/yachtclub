<?php namespace common\models;

use Yii;
use frontend\helpers\ApiHelper;

/**
 * This is the model class for table "user_pins".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $lat
 * @property string $lan
 * @property string $title
 * @property string $description
 * @property string $type
 * @property integer $approved
 *
 * @property User $user
 */
class UserPin extends \yii\db\ActiveRecord
{

    protected $pinFieldName;

    const TYPE_ANCHORAGES = 1;
    const TYPE_MOORINGS = 2;
    const TYPE_DIVESITE = 3;
    const TYPE_SNORKELSPOT = 4;
    const TYPE_SURFSPOT = 5;
    const TYPE_FUEL = 6;
    const TYPE_MARINA = 7;
    const TYPE_WARNING = 8;
    const TYPE_OTHER = 9;
    const APPROVED_FALSE = 0;
    const APPROVED_TRUE = 1;
    const APPROVED_WAITING = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_pins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['description', 'lat', 'lan'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['user_id', 'lat', 'lan', 'description', 'type'], 'required'],
            [['user_id', 'approved', 'type'], 'integer'],
            [['description'], 'string'],
            [['lat', 'lan'], 'string', 'max' => 50],
//            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('userPins', 'ID'),
            'user_id' => Yii::t('userPins', 'User ID'),
            'lat' => Yii::t('userPins', 'Lat'),
            'lan' => Yii::t('userPins', 'Lan'),
            'description' => Yii::t('userPins', 'Description'),
            'type' => Yii::t('userPins', 'Type'),
            'approved' => Yii::t('userPins', 'Approved'),
        ];
    }

    public function getAverageRating()
    {
        $rating = $this->pinField->rating;
        foreach ($this->reviewPins as $reviewPins) {
            $rating = $rating + $reviewPins->rating;
        }

        if (empty($rating)) {
            return 0;
        } else {
            return ($rating / (count($this->reviewPins) + 1));
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewPins()
    {
        return $this->hasMany(Reviews::className(), ['pin_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPinFieldName()
    {
        return !empty($this->pinField->name) ? \yii\helpers\Html::a($this->pinField->name, \yii\helpers\Url::to('../../pin/view?id=' . $this->id), ['target'=>'_blank']) : '';
    }

    public function getPinField()
    {
        return $this->hasOne(PinField::className(), ['pin_id' => 'id']);
    }

    public function getPinVessel()
    {
        return $this->hasOne(PinVessel::className(), ['pin_id' => 'id']);
    }

    public function getLatConvert()
    {
        $data = ApiHelper::convertCoordinate($this->lat);
        return $data;
    }

    public function getLanConvert()
    {
        $data = ApiHelper::convertCoordinate($this->lan);
        return $data;
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'type_name' => array(
                self::TYPE_ANCHORAGES => Yii::t('pin', 'Anchorage'),
                self::TYPE_MOORINGS => Yii::t('pin', 'Moorings'),
                self::TYPE_DIVESITE => Yii::t('pin', 'Dive Site'),
                self::TYPE_SNORKELSPOT => Yii::t('pin', 'Snorkel Spot'),
                self::TYPE_SURFSPOT => Yii::t('pin', 'Surf Spot'),
                self::TYPE_FUEL => Yii::t('pin', 'Fuel'),
                self::TYPE_MARINA => Yii::t('pin', 'Marina'),
                self::TYPE_WARNING => Yii::t('pin', 'Warning'),
                self::TYPE_OTHER => Yii::t('pin', 'Other'),
            ),
            'photo_text' => array(
                self::TYPE_ANCHORAGES => Yii::t('pin', 'Please add any photos of this anchorage that may be useful or just nice to look at, such as, hazards, the anchor site, the seabed, or sunset views.'),
                self::TYPE_MOORINGS => Yii::t('pin', 'Please add any photos of the moorings that may be insightful, such as, hazards, pick-ups, mooring balls, sunset views, or features.'),
                self::TYPE_DIVESITE => Yii::t('pin', 'Please add any photos of this dive site that may be useful or interesting, such as, hazards, features, or marine wildlife.'),
                self::TYPE_SNORKELSPOT => Yii::t('pin', 'Please add any photos of this snorkel spot that may be useful, such as, features, hazards, or views.'),
                self::TYPE_SURFSPOT => Yii::t('pin', 'Please add any photos of epic surf sessions, views from the spot, beautiful waves, etc.'),
                self::TYPE_FUEL => Yii::t('pin', 'Please add any photos of this fuel dock hat may be useful, such as, hazards, tie-up, or dock construction.'),
                self::TYPE_MARINA => Yii::t('pin', 'Please add any photos of this marina that may be insightful, such as, hazards, tie-up, dock construction, pedestals, or features.'),
                self::TYPE_WARNING => Yii::t('pin', 'Please add any photos of the described hazard that may be helpful.'),
                self::TYPE_OTHER => Yii::t('pin', 'Please add any photos that depict what this feature is about.'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public static function getPinsByAreaType($ne_lat, $sw_lat, $ne_lng, $sw_lng, $type_id)
    {

        $models = self::find()
            ->joinWith(['pinField'], true, 'INNER JOIN')
            ->andWhere(['between', UserPin::tableName() . '.lat', $sw_lat, $ne_lat])
            ->andWhere(['between', UserPin::tableName() . '.lan', $sw_lng, $ne_lng])
            ->andWhere([ UserPin::tableName() . '.approved' => self::APPROVED_TRUE])
            ->andWhere([UserPin::tableName() . '.type' => $type_id])
            ->orderBy(PinField::tableName() . '.rating DESC')
            ->all();

        return $models;
    }

    public function getImages()
    {
        return $this->hasMany(PinImage::className(), ['pin_id' => 'id']);
    }
}
