<?php namespace common\models;

use Yii;

/**
 * This is the model class for table "pin_vessels".
 *
 * @property integer $id
 * @property integer $yacht_id
 * @property integer $pin_id
 * @property string $vessel_name
 * @property string $vessel_draft
 * @property string $vessel_lenght
 * @property string $vessel_beam
 * @property string $vessel_air_draft
 * @property string $vessel_sail
 *
 * @property UserPins $yacht
 */
class PinVessel extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pin_vessels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pin_id'], 'required'],
            [['yacht_id'], 'integer'],
            [['vessel_name', 'vessel_beam', 'vessel_air_draft', 'vessel_sail'], 'string', 'max' => 255],
            [['vessel_lenght', 'vessel_draft'], 'integer', 'min' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pinVessel', 'ID'),
            'yacht_id' => Yii::t('pinVessel', 'Yacht ID'),
            'pin_id' => Yii::t('pinVessel', 'Pin ID'),
            'vessel_name' => Yii::t('pinVessel', 'Vessel Name'),
            'vessel_draft' => Yii::t('pinVessel', 'Vessel Draft'),
            'vessel_lenght' => Yii::t('pinVessel', 'Vessel Lenght'),
            'vessel_beam' => Yii::t('pinVessel', 'Vessel Beam'),
            'vessel_air_draft' => Yii::t('pinVessel', 'Vessel Air Draft'),
            'vessel_sail' => Yii::t('pinVessel', 'Vessel Sail'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYacht()
    {
        return $this->hasOne(Yacht::className(), ['id' => 'yacht_id']);
    }
}
