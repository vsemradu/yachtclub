<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yacht_crews".
 *
 * @property integer $id
 * @property integer $yacht_id
 * @property integer $crew_member_id
 *
 * @property CrewMembers $crewMember
 * @property Yachts $yacht
 */
class YachtCrew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yacht_crews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['yacht_id', 'crew_member_id'], 'required'],
            [['yacht_id', 'crew_member_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yachtCrew', 'ID'),
            'yacht_id' => Yii::t('yachtCrew', 'Yacht ID'),
            'crew_member_id' => Yii::t('yachtCrew', 'Crew Member ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrewMember()
    {
        return $this->hasOne(CrewMember::className(), ['id' => 'crew_member_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYacht()
    {
        return $this->hasOne(Yachts::className(), ['id' => 'yacht_id']);
    }
}
