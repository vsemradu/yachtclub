<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "islands".
 *
 * @property integer $id
 * @property integer $island_id
 * @property string $name
 * @property string $coordinate
 */
class Island extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'islands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['island_id', 'name', 'coordinate'], 'required'],
            [['island_id'], 'integer'],
            [['coordinate'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('island', 'ID'),
            'island_id' => Yii::t('island', 'Island ID'),
            'name' => Yii::t('island', 'Name'),
            'coordinate' => Yii::t('island', 'Coordinate'),
        ];
    }
}
