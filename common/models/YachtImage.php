<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "yacht_images".
 *
 * @property integer $id
 * @property integer $yacht_id
 * @property integer $image_id
 *
 * @property Images $image
 * @property Yachts $yacht
 */
class YachtImage extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yacht_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['yacht_id', 'image_id'], 'required'],
            [['yacht_id', 'image_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yachtImage', 'ID'),
            'yacht_id' => Yii::t('yachtImage', 'Yacht ID'),
            'image_id' => Yii::t('yachtImage', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYacht()
    {
        return $this->hasOne(Yacht::className(), ['id' => 'yacht_id']);
    }
}
