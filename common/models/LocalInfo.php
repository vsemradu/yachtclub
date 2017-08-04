<?php namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\BusinessHappyHour;

/**
 * This is the model class for table "local_infos".
 *
 * @property integer $id
 * @property string $location_lat
 * @property string $location_lng
 * @property integer $zoom
 * @property string $area_box_x
 * @property string $area_box_x2
 * @property string $area_box_y
 * @property string $area_box_y2
 * @property string $area_name
 * @property string $type_of_address
 * @property string $summary
 * @property string $customs_immigrations
 * @property string $marine_laws_regulations
 * @property string $local_life
 * @property integer $image_id
 * @property integer $featured_business_id
 * @property integer $local_life_id
 *
 * @property LocalInfoComments[] $localInfoComments
 * @property LocalInfoImages[] $localInfoImages
 * @property Images $image
 */
class LocalInfo extends \yii\db\ActiveRecord
{

    public $featured_id;
    public $local_id;
    protected $areaName;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local_infos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_lat', 'location_lng', 'zoom', 'area_box_ne_lat', 'area_box_sw_lat', 'area_box_ne_lng', 'area_box_sw_lng', 'area_name'], 'required'],
            [['zoom', 'image_id'], 'integer'],
            [['summary', 'customs_immigrations', 'marine_laws_regulations', 'local_life'], 'string'],
            [['location_lat', 'location_lng', 'area_box_ne_lat', 'area_box_sw_lat', 'area_box_ne_lng', 'area_box_sw_lng', 'area_name', 'type_of_address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('localInfo', 'ID'),
            'location_lat' => Yii::t('localInfo', 'Location Lat'),
            'location_lng' => Yii::t('localInfo', 'Location Lng'),
            'zoom' => Yii::t('localInfo', 'Zoom'),
            'area_box_ne_lat' => Yii::t('localInfo', 'Area Box ne lat'),
            'area_box_sw_lat' => Yii::t('localInfo', 'Area Box sw lat'),
            'area_box_ne_lng' => Yii::t('localInfo', 'Area Box ne lng'),
            'area_box_sw_lng' => Yii::t('localInfo', 'Area Box sw lng'),
            'area_name' => Yii::t('localInfo', 'Area Name'),
            'type_of_address' => Yii::t('localInfo', 'Type Of Address'),
            'summary' => Yii::t('localInfo', 'Summary'),
            'customs_immigrations' => Yii::t('localInfo', 'Customs Immigrations'),
            'marine_laws_regulations' => Yii::t('localInfo', 'Marine Laws Regulations'),
            'local_life' => Yii::t('localInfo', 'Local Life'),
            'image_id' => Yii::t('localInfo', 'Image ID'),
            'featured_business_id' => Yii::t('localInfo', 'Featured Business'),
            'featured_id' => Yii::t('localInfo', 'Featured Business'),
            'local_life_id' => Yii::t('localInfo', 'Local Life Business'),
            'local_id' => Yii::t('localInfo', 'Local Life Business'),
        ];
    }

    public function getAreaName()
    {
        return \yii\helpers\Html::a($this->area_name, \yii\helpers\Url::to('../../local-info/view?id=' . $this->id), ['target' => '_blank']);
    }

    public function happyHourByWeek($week)
    {

        $localInfoBusinesLocal = ArrayHelper::map($this->localInfoBusinesLocal, 'busines.id', 'busines.id');

        return $businessHappyHour = BusinessHappyHour::find()->andWhere(['in', 'business_id', $localInfoBusinesLocal])->andWhere(['week' => $week]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    //TODO: merge duplicated logic into one function and use it in all 3 ones.
    public function getSummaryJson()
    {
        return json_encode(['data' => $this->summary]);
    }

    public function getCustomsImmigrationsJson()
    {
        return json_encode(['data' => $this->customs_immigrations]);
    }

    public function getMarineLawsRegulationsJson()
    {
        return json_encode(['data' => $this->marine_laws_regulations]);
    }

    public function getLocalInfoComments()
    {
        return $this->hasMany(LocalInfoComments::className(), ['local_info_id' => 'id']);
    }

    public function getLocalInfoBusines()
    {
        return $this->hasMany(LocalInfoBusines::className(), ['local_info_id' => 'id']);
    }

    public function getLocalInfoBusinesFeature()
    {
        return $this->hasMany(LocalInfoBusines::className(), ['local_info_id' => 'id'])->where(['type' => LocalInfoBusines::TYPE_FEATURE]);
    }

    public function getLocalInfoBusinesLocal()
    {
        return $this->hasMany(LocalInfoBusines::className(), ['local_info_id' => 'id'])->where(['type' => LocalInfoBusines::TYPE_LOCAL]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalInfoImage()
    {
        return $this->hasMany(LocalInfoImage::className(), ['local_info_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
