<?php namespace common\models;

use Yii;
use vova07\fileapi\behaviors\UploadBehavior;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property string $name
 *
 * @property BlogPosts[] $blogPosts
 * @property BusinessImages[] $businessImages
 * @property YachtImages[] $yachtImages
 */
class Image extends \yii\db\ActiveRecord
{

    public $upload_image;
    public $upload_image_fon;
    public $preview_url;
    public $image_url;

    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => UploadBehavior::className(),
                'attributes' => [
                    'preview_url' => [
                        'path' => $_SERVER['DOCUMENT_ROOT'] . 'frontend/web/uploads',
                        'tempPath' => $_SERVER['DOCUMENT_ROOT'] . 'frontend/web/uploads',
                        'url' => '/url/to/previews'
                    ],
                    'image_url' => [
                        'path' => $_SERVER['DOCUMENT_ROOT'] . 'frontend/web/uploads',
                        'tempPath' => $_SERVER['DOCUMENT_ROOT'] . 'frontend/web/uploads',
                        'url' => '/url/to/images'
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['upload_image'], 'file', 'extensions' => 'gif, jpg, jpeg, png', 'skipOnEmpty' => false, 'on' => ['uploads']],
            [['upload_image'], 'file', 'extensions' => 'gif, jpg, jpeg, png', 'skipOnEmpty' => false, 'on' => ['upload_profile']],
            [['upload_image'], 'file', 'extensions' => 'gif, jpg, jpeg, png', 'skipOnEmpty' => true, 'on' => ['update']],
            [['upload_image'], 'file', 'extensions' => 'gif, jpg, jpeg, png', 'maxFiles' => 10, 'skipOnEmpty' => true, 'on' => ['pins']],
            [['upload_image_fon'], 'file', 'extensions' => 'gif, jpg, jpeg, png', 'skipOnEmpty' => false, 'on' => ['uploads']],
            [['upload_image_fon'], 'file', 'extensions' => 'gif, jpg, jpeg, png', 'skipOnEmpty' => true, 'on' => ['update']],
            [['upload_image_fon'], 'file', 'extensions' => 'gif, jpg, jpeg, png', 'maxFiles' => 10, 'skipOnEmpty' => true, 'on' => ['pins']],
            [['upload_image', 'upload_image_fon', 'image_url', 'preview_url'], 'file', 'extensions' => 'gif, jpg, jpeg, png', 'skipOnEmpty' => true, 'on' => ['default']],
            [['name'], 'string', 'max' => 255, 'on' => ['insert']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('image', 'ID'),
            'name' => Yii::t('image', 'Name'),
            'upload_image' => Yii::t('image', 'Image'),
            'upload_image_fon' => Yii::t('image', 'Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPosts()
    {
        return $this->hasMany(BlogPosts::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessImages()
    {
        return $this->hasMany(BusinessImages::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYachtImages()
    {
        return $this->hasMany(YachtImages::className(), ['image_id' => 'id']);
    }

    public static function deleteImage($id)
    {
        $model = static::findOne(['id' => $id]);
        $path = \Yii::getAlias('@frontend/web/uploads/') . $model->name;
        if (file_exists($path)) {
            unlink($path);
        }
        $model->delete();
    }

    public function uploads()
    {

        $this->scenario = 'insert';
        $name = uniqid('file_');
        $this->upload_image->saveAs(\Yii::getAlias('@frontend/web/uploads/') . $name . '.' . $this->upload_image->extension);
        $this->name = $name . '.' . $this->upload_image->extension;
        $this->upload_image = '';
        $this->save();
        return $this->id;
    }

    //CamelCase? 


    public function getImageUrl()
    {
        return Yii::$app->urlManager->createAbsoluteUrl('/frontend/web/uploads/' . $this->name);
    }

    public function getAdminImageUrl()
    {
        return Yii::$app->urlManagerFrontEnd->createAbsoluteUrl('/frontend/web/uploads/' . $this->name);
    }
}
