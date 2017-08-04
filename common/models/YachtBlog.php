<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yacht_blogs".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property integer $yacht_id
 *
 * @property BlogPosts $blog
 * @property Yachts $yacht
 */
class YachtBlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yacht_blogs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'yacht_id'], 'required'],
            [['blog_id', 'yacht_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yachtBlog', 'ID'),
            'blog_id' => Yii::t('yachtBlog', 'Blog ID'),
            'yacht_id' => Yii::t('yachtBlog', 'Yacht ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(BlogPosts::className(), ['id' => 'blog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYacht()
    {
        return $this->hasOne(Yachts::className(), ['id' => 'yacht_id']);
    }
}
