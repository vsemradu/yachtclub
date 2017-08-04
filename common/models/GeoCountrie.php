<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "geo_countries".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 */
class GeoCountrie extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('geoCountrie', 'ID'),
            'code' => Yii::t('geoCountrie', 'Code'),
            'name' => Yii::t('geoCountrie', 'Name'),
        ];
    }
}
