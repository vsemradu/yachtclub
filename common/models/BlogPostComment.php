<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_post_comments".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property integer $user_id
 * @property string $text
 * @property integer $date_create
 *
 * @property BlogPosts $blog
 * @property User $user
 */
class BlogPostComment extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_post_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['date_create', 'default', 'value' => time(), 'on' => ['insert']],
            ['text', 'filter', 'filter' => function($value) {
                    return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
                }],
                ['text', 'filter', 'filter' => 'trim'],
                ['text', 'string', 'max' => 255],
                [['blog_id', 'user_id', 'text'], 'required'],
                [['blog_id', 'user_id', 'date_create'], 'integer'],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id' => Yii::t('blogPostComment', 'ID'),
                'blog_id' => Yii::t('blogPostComment', 'Blog ID'),
                'user_id' => Yii::t('blogPostComment', 'User ID'),
                'text' => Yii::t('blogPostComment', 'Comment'),
                'date_create' => Yii::t('blogPostComment', 'Date Create'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getBlog()
        {
            return $this->hasOne(BlogPosts::className(), ['id' => 'blog_id']);
        }

        public function getDateCreate()
        {
            return Yii::$app->formatter->asDate($this->date_create);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getUser()
        {
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }
    }
    