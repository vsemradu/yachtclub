<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "business_images".
 *
 * @property integer $id
 * @property integer $image_id
 * @property integer $business_id
 *
 * @property Business $business
 * @property Images $image
 */
class BusinessImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'business_id'], 'required'],
            [['image_id', 'business_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('businessImages', 'ID'),
            'image_id' => Yii::t('businessImages', 'Image ID'),
            'business_id' => Yii::t('businessImages', 'Business ID'),
        ];
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
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
