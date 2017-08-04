<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "local_info_business".
 *
 * @property integer $id
 * @property integer $local_info_id
 * @property integer $business_id
 * @property string $type
 *
 * @property LocalInfos $localInfo
 * @property Business $business
 */
class LocalInfoBusines extends \yii\db\ActiveRecord
{
    const TYPE_LOCAL = 'local';
    const TYPE_FEATURE = 'feature';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local_info_business';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['local_info_id', 'business_id', 'type'], 'required'],
            [['local_info_id', 'business_id'], 'integer'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('localInfoBusines', 'ID'),
            'local_info_id' => Yii::t('localInfoBusines', 'Local Info ID'),
            'business_id' => Yii::t('localInfoBusines', 'Business ID'),
            'type' => Yii::t('localInfoBusines', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalInfo()
    {
        return $this->hasOne(LocalInfos::className(), ['id' => 'local_info_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusines()
    {
        return $this->hasOne(Busines::className(), ['id' => 'business_id']);
    }
}
