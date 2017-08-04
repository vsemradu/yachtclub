<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "local_info_images".
 *
 * @property integer $id
 * @property integer $local_info_id
 * @property integer $image_id
 *
 * @property LocalInfos $localInfo
 * @property Images $image
 */
class LocalInfoImage extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local_info_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['local_info_id', 'image_id'], 'required'],
            [['local_info_id', 'image_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('localInfoImage', 'ID'),
            'local_info_id' => Yii::t('localInfoImage', 'Local Info ID'),
            'image_id' => Yii::t('localInfoImage', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalInfo()
    {
        return $this->hasOne(LocalInfo::className(), ['id' => 'local_info_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
