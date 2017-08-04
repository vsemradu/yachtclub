<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "crew_members".
 *
 * @property integer $id
 * @property string $name
 * @property integer $photo_id
 * @property string $role
 * @property integer $role_id
 *
 * @property YachtCrews[] $yachtCrews
 */
class CrewMember extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crew_members';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['name', 'role'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['name', 'role_id'], 'required'],
            [['photo_id', 'role_id'], 'integer'],
            [['name', 'role'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crewMember', 'ID'),
            'name' => Yii::t('crewMember', 'Name'),
            'photo_id' => Yii::t('crewMember', 'Photo ID'),
            'role' => Yii::t('crewMember', 'Role'),
            'role_id' => Yii::t('crewMember', 'Role'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYachtCrews()
    {
        return $this->hasMany(YachtCrew::className(), ['crew_member_id' => 'id']);
    }

    public function getPhoto()
    {
        return $this->hasOne(Image::className(), ['id' => 'photo_id']);
    }

    public function getCrewRole()
    {
        return $this->hasOne(CrewMemberRole::className(), ['id' => 'role_id']);
    }
}
