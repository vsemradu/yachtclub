<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "crew_member_roles".
 *
 * @property integer $id
 * @property string $name
 */
class CrewMemberRole extends \yii\db\ActiveRecord
{

    const TYPE_OTHER = 10000;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crew_member_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crewMemberRole', 'ID'),
            'name' => Yii::t('crewMemberRole', 'Name'),
        ];
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'type_title' => array(
                self::TYPE_OTHER => Yii::t('crewMemberRole', 'Other'),
                
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
}
