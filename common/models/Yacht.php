<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "yachts".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type_id
 * @property integer $type
 * @property integer $subtype
 * @property string $name
 * @property integer $year
 * @property string $yacht_build
 * @property string $home_port
 * @property string $length
 * @property string $beam
 * @property string $draft
 * @property string $air_draft
 * @property string $website
 * @property string $summary
 * @property integer $background_image_id
 * @property string $enable_blog
 * @property string $charter_company
 * @property string $contact_info
 *
 * @property ReviewYacht[] $reviewYachts
 * @property YachtBlogs[] $yachtBlogs
 * @property YachtCrews[] $yachtCrews
 * @property YachtImages[] $yachtImages
 * @property User $user
 */
class Yacht extends \yii\db\ActiveRecord
{

    const TYPE_CHARTER = 1;
    const TYPE_PRIVATE = 2;
    const TYPE_PRIVATE_CREWED = 3;
    const TYPE_PRIVATE_OWNER = 4;
    const TYPE_CHARTER_CREWED = 5;
    const TYPE_CHARTER_BARE = 6;
    const TYPE_SAIL = 1;
    const TYPE_POWER = 2;
    const TYPE_CATAMARAN = 3;
    const TYPE_MONOHULL = 4;
    const TYPE_OTHER = 5;
    const ENABLE_BLOG_TRUE = 1;
    const ENABLE_BLOG_FALSE = 0;
    const SHARE_TRUE = 1;
    const SHARE_FALSE = 0;
    const CHARTET_BUTTON_TRUE = 1;
    const CHARTET_BUTTON_FALSE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yachts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'yacht_type', 'yacht_build', 'home_port', 'length', 'beam', 'draft', 'air_draft', 'website', 'summary', 'enable_blog', 'charter_company', 'contact_info', 'crew_description', 'summary'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['website'], 'url', 'defaultScheme' => 'http'],
            [['user_id', 'type_id', 'subtype', 'name',], 'required'],
            [['user_id', 'type_id', 'yacht_type_id', 'yacht_type_two_id', 'subtype', 'year', 'background_image_id', 'share', 'charter_button', 'rate'], 'integer'],
            [['name', 'yacht_type', 'yacht_build', 'home_port', 'beam', 'draft', 'air_draft', 'website', 'summary', 'enable_blog', 'charter_company', 'contact_info'], 'string', 'max' => 255],
            [['length'], 'integer', 'min' => 1],
            [['crew_description', 'summary'], 'string'],
            ['date_create', 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yacht', 'ID'),
            'user_id' => Yii::t('yacht', 'User ID'),
            'type_id' => Yii::t('yacht', 'Type ID'),
            'type' => Yii::t('yacht', 'Type'),
            'subtype' => Yii::t('yacht', 'Subtype'),
            'name' => Yii::t('yacht', 'Name'),
            'year' => Yii::t('yacht', 'Year'),
            'yacht_build' => Yii::t('yacht', 'Yacht Build'),
            'home_port' => Yii::t('yacht', 'Home Port'),
            'length' => Yii::t('yacht', 'Length'),
            'beam' => Yii::t('yacht', 'Beam'),
            'draft' => Yii::t('yacht', 'Draft'),
            'air_draft' => Yii::t('yacht', 'Air Draft'),
            'website' => Yii::t('yacht', 'Website'),
            'summary' => Yii::t('yacht', 'Summary'),
            'background_image_id' => Yii::t('yacht', 'Background Image ID'),
            'enable_blog' => Yii::t('yacht', 'Enable Blog'),
            'charter_company' => Yii::t('yacht', 'Charter Company'),
            'contact_info' => Yii::t('yacht', 'Contact Info'),
            'rate' => Yii::t('yacht', 'Rate'),
        ];
    }

    public function getAverageRating()
    {
        $rating = 0;
        foreach ($this->reviewYachts as $reviewYachts) {
            $rating = $rating + $reviewYachts->rating;
        }
        if (empty($rating)) {
            return 0;
        } else {
            return $rating / (count($this->reviewYachts));
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewYachts()
    {
        return $this->hasMany(Reviews::className(), ['yacht_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYachtBlogs()
    {
        return $this->hasMany(YachtBlog::className(), ['yacht_id' => 'id']);
    }

    public function getYachtBlogIds()
    {
        $id = [];
        foreach ($this->yachtBlogs as $yachtBlogs) {
            $id[] = $yachtBlogs->blog_id;
        }
        return $id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYachtCrews()
    {
        return $this->hasMany(YachtCrew::className(), ['yacht_id' => 'id']);
    }

    public function getUpdateYachtCrews()
    {
        $data = [];
        if (!empty($this->yachtCrews)) {
            foreach ($this->yachtCrews as $yachtCrews) {
                $data[] = $yachtCrews->crewMember;
            }
        }

        return $data;
    }

    public function getYachtSeason()
    {
        return $this->hasMany(YachtSeason::className(), ['yacht_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYachtImages()
    {
        return $this->hasMany(YachtImage::className(), ['yacht_id' => 'id']);
    }

    public function getYachtImageFon()
    {
        return $this->hasOne(Image::className(), ['id' => 'background_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'type_yacht' => array(
                self::TYPE_SAIL => Yii::t('yacht', 'Sail'),
                self::TYPE_POWER => Yii::t('yacht', 'Power'),
            ),
            'type_yacht_two' => array(
                self::TYPE_CATAMARAN => Yii::t('yacht', 'Catamaran'),
                self::TYPE_MONOHULL => Yii::t('yacht', 'Monohull'),
                self::TYPE_OTHER => Yii::t('yacht', 'Other'),
            ),
            'type_by_subtype' => array(
                self::TYPE_PRIVATE_CREWED => self::TYPE_PRIVATE,
                self::TYPE_PRIVATE_OWNER => self::TYPE_PRIVATE,
                self::TYPE_CHARTER_BARE => self::TYPE_CHARTER,
                self::TYPE_CHARTER_CREWED => self::TYPE_CHARTER,
            ),
            'subtype_title' => array(
                self::TYPE_PRIVATE_CREWED => 'CREWED PRIVATE BOAT',
                self::TYPE_PRIVATE_OWNER => 'OWNER OPERATED PRIVATE BOAT',
                self::TYPE_CHARTER_BARE => 'BAR BOAT',
                self::TYPE_CHARTER_CREWED => 'CREWED CHARTER BOAT',
            ),
            'summery_place_holder' => array(
                self::TYPE_PRIVATE_CREWED => 'Please, enter a summary about your vessel and if you wish, any other information, such as your past, present, and future journeys or anything else you would like to share.',
                self::TYPE_PRIVATE_OWNER => 'Please leave a short summary about your vessel and journey this far.',
                self::TYPE_CHARTER_BARE => 'Please give us a summary about the vessel, proposed charter grounds, or anything else that may interest perspective clients.',
                self::TYPE_CHARTER_CREWED => 'Please give us a summary about the charter side of your vessel. For example - Suggested cruising grounds, theme nights, overall experience, etc.',
            ),
            'photo_label' => array(
                self::TYPE_PRIVATE_CREWED => 'Please add any photos that you wish to share on your Yacht Profile Page.',
                self::TYPE_PRIVATE_OWNER => 'Feel free to add any photos of your journey and vessel.',
                self::TYPE_CHARTER_BARE => 'Please add any photos of the vessel that may be useful for potential clients looking to book a charter.',
                self::TYPE_CHARTER_CREWED => 'Please upload any relevant photos that may be useful or interesting for potential clients searching to book a charter.',
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
}
