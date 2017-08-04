<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_posts".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $image_id
 * @property string $title
 * @property string $description
 * @property string $type
 *
 * @property BlogPostComments[] $blogPostComments
 * @property Images $image
 * @property User $user
 * @property BusinessBlogs[] $businessBlogs
 * @property YachtBlogs[] $yachtBlogs
 */
class BlogPost extends \yii\db\ActiveRecord
{

    const TYPE_CURRENT = 'current';
    const TYPE_WEEK = 'week';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['date_create', 'default', 'value' => time(), 'on' => ['insert']],
            [['user_id', 'image_id'], 'integer'],
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title', 'type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'user_id' => Yii::t('blog', 'User ID'),
            'image_id' => Yii::t('blog', 'Image ID'),
            'title' => Yii::t('blog', 'Title'),
            'description' => Yii::t('blog', 'Description'),
            'type' => Yii::t('blog', 'Type'),
            'date_create' => Yii::t('blog', 'date create'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDateCreate()
    {
        return Yii::$app->formatter->asDate($this->date_create);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLittleDescription($count = 200)
    {

        $string = strip_tags($this->description);
        $string = substr($string, 0, $count);
        $string = rtrim($string, "!,.-");
        $string = substr($string, 0, strrpos($string, ' '));
        return $string . "… ";
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPostComments()
    {
        return $this->hasMany(BlogPostComment::className(), ['blog_id' => 'id']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessBlog()
    {
        //TODO: Blogs changed to Blog. HasMany need to be changed to hasOne
        return $this->hasMany(BusinessBlog::className(), ['blog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYachtBlog()
    {
        return $this->hasMany(YachtBlog::className(), ['blog_id' => 'id']);
    }

    public function getYacht()
    {
        return $this->hasOne(Yacht::className(), ['id' => 'yacht_id'])->via('yachtBlog');
    }

    public function getImageUrl()
    {
        if (!empty($this->image_id)) {
            return \yii\helpers\Url::to('/frontend/web/uploads/' . $this->image->name);
        }
        return;
    }

    //TODO: NULL should be lowercase - null
    public static function itemAlias($type, $code = null)
    {
        $_items = [
            'type' => [
                self::TYPE_CURRENT => \Yii::t('blog', 'Main block'),
                self::TYPE_WEEK => \Yii::t('blog', 'Feature of the week'),
            ]
        ];
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
}
