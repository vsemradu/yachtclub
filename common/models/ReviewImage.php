<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "review_images".
 *
 * @property integer $id
 * @property integer $review_id
 * @property integer $image_id
 *
 * @property Reviews $review
 * @property Images $image
 */
class ReviewImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['review_id', 'image_id'], 'required'],
            [['review_id', 'image_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('reviewImage', 'ID'),
            'review_id' => Yii::t('reviewImage', 'Review ID'),
            'image_id' => Yii::t('reviewImage', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['id' => 'review_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
