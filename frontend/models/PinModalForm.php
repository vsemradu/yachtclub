<?php namespace frontend\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class PinModalForm extends Model
{

    public $lat;
    public $lan;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat', 'lan'], 'filter', 'filter' => 'trim'],
            [['lat', 'lan'], 'required'],
            [['lat'], 'number', 'min' => -90, 'max' => 90],
            [['lan'], 'number', 'min' => -180, 'max' => 180],
        ];
    }

    public function attributeLabels()
    {
        return [
            'lat' => \Yii::t('pinModalForm', 'Latitude'),
            'lan' => \Yii::t('pinModalForm', 'Longitude'),
        ];
    }
}
