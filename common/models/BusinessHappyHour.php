<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "business_happy_hours".
 *
 * @property integer $id
 * @property integer $business_id
 * @property string $week
 * @property string $special
 *
 * @property Business $business
 */
class BusinessHappyHour extends \yii\db\ActiveRecord
{

    const WEEK_MONDAY = 'monday';
    const WEEK_TUESDAY = 'tuesday';
    const WEEK_WEDNESDAY = 'wednesday';
    const WEEK_THURSDAY = 'thursday';
    const WEEK_FRIDAY = 'friday';
    const WEEK_SATURDAY = 'saturday';
    const WEEK_SUNDAY = 'sunday';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_happy_hours';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['special', 'week'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['special', 'week'], 'required'],
            [['business_id'], 'integer'],
            [['special'], 'string'],
            [['week'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('businessHappyHour', 'ID'),
            'business_id' => Yii::t('businessHappyHour', 'Business ID'),
            'week' => Yii::t('businessHappyHour', 'Week'),
            'special' => Yii::t('businessHappyHour', 'Special'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusines()
    {
        return $this->hasOne(Busines::className(), ['id' => 'business_id']);
    }
    
    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'week_title' => array(
                self::WEEK_MONDAY => 'Monday',
                self::WEEK_TUESDAY => 'Tuesday',
                self::WEEK_WEDNESDAY => 'Wednesday',
                self::WEEK_THURSDAY => 'Thursday',
                self::WEEK_FRIDAY => 'Friday',
                self::WEEK_SATURDAY => 'Saturday',
                self::WEEK_SUNDAY => 'Sunday',
            ),
          
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
}
