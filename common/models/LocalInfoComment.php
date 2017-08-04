<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "local_info_comments".
 *
 * @property integer $id
 * @property integer $local_info_id
 * @property integer $user_id
 * @property integer $rate
 * @property string $text
 * @property integer $type
 * @property integer $date_create
 *
 * @property LocalInfos $localInfo
 * @property User $user
 */
class LocalInfoComment extends \yii\db\ActiveRecord
{
    const TYPE_COMMENT = 1;
    const TYPE_TIP_TRICK = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local_info_comments';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['local_info_id', 'user_id', 'text', 'date_create'], 'required'],
            [['local_info_id', 'user_id', 'rate', 'type', 'date_create'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('localInfoComment', 'ID'),
            'local_info_id' => Yii::t('localInfoComment', 'Local Info ID'),
            'user_id' => Yii::t('localInfoComment', 'User ID'),
            'rate' => Yii::t('localInfoComment', 'Rate'),
            'text' => Yii::t('localInfoComment', 'Text'),
            'type' => Yii::t('localInfoComment', 'Type'),
            'date_create' => Yii::t('localInfoComment', 'Date Create'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDateCreate()
    {
        return Yii::$app->formatter->asDate($this->date_create);
    }
}
