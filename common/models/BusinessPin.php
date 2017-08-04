<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "business_pins".
 *
 * @property integer $id
 * @property integer $pin_id
 * @property integer $business_id
 *
 * @property Business $business
 */
class BusinessPin extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_pins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pin_id', 'business_id'], 'required'],
            [['pin_id', 'business_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('businessPin', 'ID'),
            'pin_id' => Yii::t('businessPin', 'Pin ID'),
            'business_id' => Yii::t('businessPin', 'Business ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(Busines::className(), ['id' => 'business_id']);
    }

    public function getPin()
    {
        return $this->hasOne(UserPin::className(), ['id' => 'pin_id']);
    }
}
