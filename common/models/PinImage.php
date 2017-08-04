<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pin_images".
 *
 * @property integer $id
 * @property integer $pin_id
 * @property integer $image_id
 *
 * @property UserPins $pin
 * @property Images $image
 */
class PinImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pin_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pin_id', 'image_id'], 'required'],
            [['pin_id', 'image_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pinImage', 'ID'),
            'pin_id' => Yii::t('pinImage', 'Pin ID'),
            'image_id' => Yii::t('pinImage', 'Image ID'),
        ];
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
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
