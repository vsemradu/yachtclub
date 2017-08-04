<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "yacht_season".
 *
 * @property integer $id
 * @property integer $yacht_id
 * @property string $season
 * @property double $from
 * @property double $to
 *
 * @property Yachts $yacht
 */
class YachtSeason extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yacht_season';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['season', 'from', 'to', 'currency'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['season', 'currency', 'from', 'to'], 'required'],
            [['yacht_id'], 'integer'],
            [['from', 'to'], 'number','min'=>1],
            [['season'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            ['currency', 'default', 'value' => '$'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yachtSeason', 'ID'),
            'yacht_id' => Yii::t('yachtSeason', 'Yacht ID'),
            'season' => Yii::t('yachtSeason', 'Season'),
            'from' => Yii::t('yachtSeason', 'From'),
            'to' => Yii::t('yachtSeason', 'To'),
            'currency' => Yii::t('yachtSeason', 'Currency'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYacht()
    {
        return $this->hasOne(Yachts::className(), ['id' => 'yacht_id']);
    }
}
