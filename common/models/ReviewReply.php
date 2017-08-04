<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "review_replies".
 *
 * @property integer $id
 * @property integer $review_id
 * @property integer $user_id
 * @property string $text
 * @property string $type
 * @property integer $date_create
 *
 * @property Reviews $review
 * @property User $user
 */
class ReviewReply extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review_replies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['text', 'type'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            ['user_id', 'default', 'value' => \Yii::$app->user->id],
            [['review_id', 'text', 'type', 'date_create'], 'required'],
            [['review_id', 'user_id', 'date_create'], 'integer'],
            [['text'], 'string'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('reviewReply', 'ID'),
            'review_id' => Yii::t('reviewReply', 'Review ID'),
            'user_id' => Yii::t('reviewReply', 'User ID'),
            'text' => Yii::t('reviewReply', 'Text'),
            'type' => Yii::t('reviewReply', 'Type'),
            'date_create' => Yii::t('reviewReply', 'Date Create'),
        ];
    }

    public function getDateCreate()
    {
        return Yii::$app->formatter->asDate($this->date_create);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Reviews::className(), ['id' => 'review_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
