<?php namespace common\models;

use Yii;
use common\models\UserPin;
use yii\helpers\Json;

/**
 * This is the model class for table "pin_fields".
 *
 * TODO: Add descriptions for attributes
 * @property integer $id
 * @property string $name
 * @property integer $rating
 * @property integer $quality_rating
 * @property integer $novice
 * @property integer $intermidiate
 * @property integer $expert
 * @property string $warnings
 * @property string $sea_swell
 * @property string $wind_direction
 * @property string $overnight_price
 * @property integer $ice
 * @property integer $provisions
 * @property integer $pestaurant
 * @property integer $fuel
 * @property integer $port_of_entry
 * @property string $vessel_lenght
 * @property integer $vessel_lenght_type
 * @property string $vessel_draft
 * @property integer $vessel_draft_type
 * @property string $max_depth
 * @property integer $visibility
 * @property string $dive_operator_name
 * @property string $dive_operator_address
 * @property string $location
 * @property integer $reef_vreak
 * @property integer $beach_break
 * @property integer $break
 * @property string $swell_hight
 * @property string $swell_direction
 * @property string $fuel_price
 * @property integer $point_break
 * @property integer $fuel_price_type
 * @property string $water_price
 * @property integer $water_price_type
 * @property integer $restaurant
 * @property integer $electric_services
 * @property string $electricity_price
 * @property string $dockage_price
 * @property integer $dockage_price_type
 * @property integer $intermediate
 * @property integer $how_severe
 */
class PinField extends \yii\db\ActiveRecord
{

    public $_rating = [
        UserPin::TYPE_ANCHORAGES,
        UserPin::TYPE_MOORINGS,
        UserPin::TYPE_DIVESITE,
        UserPin::TYPE_SNORKELSPOT,
        UserPin::TYPE_SURFSPOT,
        UserPin::TYPE_FUEL,
        UserPin::TYPE_MARINA,
        UserPin::TYPE_OTHER,
    ];
    public $_max_depth = [
        UserPin::TYPE_DIVESITE,
    ];
    public $_location = [
        UserPin::TYPE_SURFSPOT,
    ];

    const VESSEL_TYPE_FEET = 1;
    const VESSEL_TYPE_METTERS = 2;
    const WATTER_TYPE_GALLON = 1;
    const WATTER_TYPE_LITER = 2;
    const DIVESITE_VISIBILITY_MURKY = 1;
    const DIVESITE_VISIBILITY_MODERATE = 2;
    const DIVESITE_VISIBILITY_CRYSTAL = 3;
    const SURFSPOT_BREAKS_LEFT = 1;
    const SURFSPOT_BREAKS_BOTH = 2;
    const SURFSPOT_BREAKS_RIGHT = 3;
    const FUEL_FUEL_GREAT = 1;
    const FUEL_FUEL_GOOD = 2;
    const FUEL_FUEL_BAD = 3;
    const WARNING_HOW_SEVERE_YELLOW = 1;
    const WARNING_HOW_SEVERE_ORANGE = 2;
    const WARNING_HOW_SEVERE_RED = 3;
    const ELECTRIC_SERVICE_30AM = '30am';
    const ELECTRIC_SERVICE_50AM = '50am';
    const ELECTRIC_SERVICE_100AMPSP = '100ampsp';
    const ELECTRIC_SERVICE_100AMP3P = '100amp3p';
    const ELECTRIC_SERVICE_480V = '480v';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pin_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['warnings', 'name', 'sea_swell', 'wind_direction', 'overnight_price', 'vessel_lenght', 'vessel_draft', 'max_depth', 'dive_operator_name', 'dive_operator_address', 'location', 'swell_hight', 'swell_direction', 'fuel_price', 'water_price', 'electricity_price', 'dockage_price'], 'filter', 'filter' => function($value) {
                return \yii\helpers\HtmlPurifier::process($value, ['HTML.Allowed' => '']);
            }],
            [['name'], 'required'],
            [['rating'], 'required', 'when' => function($model) {
                return in_array($model->type_id, $this->_rating);
            }],
            [['max_depth'], 'required', 'when' => function($model) {
                return in_array($model->type_id, $this->_max_depth);
            }],
            [['location'], 'required', 'when' => function($model) {
                return in_array($model->type_id, $this->_location);
            }],
            ['rating', 'compare', 'compareValue' => 0, 'operator' => '!=', 'message' => \Yii::t('pinField', 'Can not be blank.'), 'when' => function($model) {
                    return in_array($model->type_id, $this->_rating);
                }],
            [['pin_id', 'rating', 'quality_rating', 'novice', 'intermidiate', 'expert', 'ice', 'provisions', 'pestaurant', 'fuel', 'port_of_entry', 'vessel_lenght_type', 'vessel_draft_type', 'visibility', 'reef_vreak', 'beach_break', 'break', 'point_break', 'fuel_price_type', 'water_price_type', 'restaurant', 'dockage_price_type', 'intermediate', 'how_severe', 'type_id', 'max_depth_type', 'swell_hight_type'], 'integer'],
            [['warnings', 'summary'], 'string'],
            [['name', 'sea_swell', 'wind_direction', 'overnight_price', 'dive_operator_name', 'dive_operator_address', 'location', 'swell_direction', 'fuel_price'], 'string', 'max' => 255],
            [['vessel_lenght', 'vessel_draft', 'max_depth', 'swell_hight', 'electricity_price', 'dockage_price', 'water_price'], 'integer', 'min' => 1],
            ['electric_services', 'filter', 'filter' => function ($value) {
                    return Json::encode($value);
                }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getRatingList()
    {
        $data = array();
        if (!empty($this->intermidiate)) {
            $data[] = Yii::t('pinField', 'Intermediate');
        }

        if (!empty($this->novice)) {
            $data[] = Yii::t('pinField', 'Novice');
        }

        if (!empty($this->expert)) {
            $data[] = Yii::t('pinField', 'Expert');
        }
        return implode(", ", $data);
    }

    public function getBreakList()
    {
        $data = '';
        if ($this->break == self::SURFSPOT_BREAKS_LEFT) {
            $data = Yii::t('pinField', 'Left');
        } elseif ($this->break == self::SURFSPOT_BREAKS_BOTH) {
            $data = Yii::t('pinField', 'Both');
        } elseif ($this->break == self::SURFSPOT_BREAKS_RIGHT) {
            $data = Yii::t('pinField', 'Right');
        }
        return $data;
    }

    public function getVisibilityList()
    {
        $data = '';
        if ($this->visibility == self::DIVESITE_VISIBILITY_CRYSTAL) {
            $data = Yii::t('pinField', 'Crystal');
        } elseif ($this->visibility == self::DIVESITE_VISIBILITY_MODERATE) {
            $data = Yii::t('pinField', 'Moderate');
        } elseif ($this->visibility == self::DIVESITE_VISIBILITY_MURKY) {
            $data = Yii::t('pinField', 'Murky');
        }
        return $data;
    }

    public function getQualityRatingList()
    {
        $data = '';
        if ($this->quality_rating == self::FUEL_FUEL_GREAT) {
            //TODO: Change to Html::img
            $data = '<img src="../img/green_ico.png" alt="">' . Yii::t('pinField', 'Greate');
        } elseif ($this->quality_rating == self::FUEL_FUEL_GOOD) {
            $data = '<img src="../img/yellow_ico.png" alt="">' . Yii::t('pinField', 'Good');
        } elseif ($this->quality_rating == self::FUEL_FUEL_BAD) {
            $data = '<img src="../img/red_ico.png" alt="">' . Yii::t('pinField', 'Bad');
        }
        return $data;
    }

    //TODO: Add descriptions to methods in PHPDoc format
    public function getResourcesWithinList()
    {
        $data = array();
        if (!empty($this->ice)) {
            $data[] = Yii::t('pinField', 'Ice');
        }

        if (!empty($this->provisions)) {
            $data[] = Yii::t('pinField', 'Provisions');
        }

        if (!empty($this->pestaurant)) {
            $data[] = Yii::t('pinField', 'Restaurant');
        }
        if (!empty($this->fuel)) {
            $data[] = Yii::t('pinField', 'Fuel');
        }
        if (!empty($this->port_of_entry)) {
            $data[] = Yii::t('pinField', 'Port of entry');
        }

        return implode(", ", $data);
    }

    public function getReefPointBeachBreak()
    {
        $data = array();
        if (!empty($this->reef_vreak)) {
            $data[] = Yii::t('pinField', 'Reef Break');
        }

        if (!empty($this->beach_break)) {
            $data[] = Yii::t('pinField', 'Beach Break');
        }

        if (!empty($this->point_break)) {
            $data[] = Yii::t('pinField', 'Point Break');
        }

        return implode(", ", $data);
    }

    public function getHowSevereList()
    {
        $data = '';
        if ($this->how_severe == self::WARNING_HOW_SEVERE_YELLOW) {
            $data = '<i class="fa fa-exclamation-triangle yellow"></i>';
        } elseif ($this->how_severe == self::WARNING_HOW_SEVERE_ORANGE) {
            $data = '<i class="fa fa-exclamation-triangle orange"></i>';
        } elseif ($this->how_severe == self::WARNING_HOW_SEVERE_RED) {
            $data = '<i class="fa fa-exclamation-triangle red"></i>';
        }
        return $data;
    }

    public function getElectricServices()
    {
        $data = array();
        if ($this->electric_services != '') {
            $electric_servicess = Json::decode(Json::decode($this->electric_services, true), true);
            if (!empty($electric_servicess)) {
                foreach ($electric_servicess as $electric_services) {
                    $data[] = self::itemAlias('electric_services', $electric_services);
                }
            }
        }

        return !empty($data) ? implode(", ", $data) : '';
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pinField', 'ID'),
            'pin_id' => Yii::t('pinField', 'pin id'),
            'type_id' => Yii::t('pinField', 'type_id'),
            'name' => Yii::t('pinField', 'Name'),
            'rating' => Yii::t('pinField', 'Rating'),
            'quality_rating' => Yii::t('pinField', 'Quality Rating'),
            'novice' => Yii::t('pinField', 'Novice'),
            'intermidiate' => Yii::t('pinField', 'Intermediate'),
            'expert' => Yii::t('pinField', 'Expert'),
            'warnings' => Yii::t('pinField', 'Warnings'),
            'sea_swell' => Yii::t('pinField', 'Sea Swell'),
            'wind_direction' => Yii::t('pinField', 'Wind Direction'),
            'overnight_price' => Yii::t('pinField', 'Overnight Price'),
            'ice' => Yii::t('pinField', 'Ice'),
            'provisions' => Yii::t('pinField', 'Provisions'),
            'pestaurant' => Yii::t('pinField', 'Restaurant'),
            'fuel' => Yii::t('pinField', 'Fuel'),
            'port_of_entry' => Yii::t('pinField', 'Port Of Entry'),
            'vessel_lenght' => Yii::t('pinField', 'Vessel Lenght'),
            'vessel_lenght_type' => Yii::t('pinField', 'Vessel Lenght Type'),
            'vessel_draft' => Yii::t('pinField', 'Vessel Draft'),
            'vessel_draft_type' => Yii::t('pinField', 'Vessel Draft Type'),
            'max_depth' => Yii::t('pinField', 'Max Depth'),
            'max_depth_type' => Yii::t('pinField', 'Max Depth type'),
            'visibility' => Yii::t('pinField', 'Visibility'),
            'dive_operator_name' => Yii::t('pinField', 'Dive Operator Name'),
            'dive_operator_address' => Yii::t('pinField', 'Dive Operator Address'),
            'location' => Yii::t('pinField', 'Location'),
            'reef_vreak' => Yii::t('pinField', 'Reef Break'),
            'beach_break' => Yii::t('pinField', 'Beach Break'),
            'break' => Yii::t('pinField', 'Break'),
            'swell_hight' => Yii::t('pinField', 'Swell Hight'),
            'swell_hight_type' => Yii::t('pinField', 'Swell Hight type'),
            'swell_direction' => Yii::t('pinField', 'Swell Direction'),
            'fuel_price' => Yii::t('pinField', 'Fuel Price'),
            'point_break' => Yii::t('pinField', 'Point Break'),
            'fuel_price_type' => Yii::t('pinField', 'Fuel Price Type'),
            'water_price' => Yii::t('pinField', 'Water Price'),
            'water_price_type' => Yii::t('pinField', 'Water Price Type'),
            'restaurant' => Yii::t('pinField', 'Restaurant'),
            'electric_services' => Yii::t('pinField', 'Electric Services'),
            'electricity_price' => Yii::t('pinField', 'Electricity Price'),
            'dockage_price' => Yii::t('pinField', 'Dockage Price'),
            'dockage_price_type' => Yii::t('pinField', 'Dockage Price Type'),
            'intermediate' => Yii::t('pinField', 'Intermediate'),
            'how_severe' => Yii::t('pinField', 'How Severe'),
            'summary' => Yii::t('pinField', 'Summary'),
        ];
    }

    //TODO: Use PSR-2 standard. E.g. NULL should be null
    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'vessel_type' => array(
                self::VESSEL_TYPE_FEET => 'feet',
                self::VESSEL_TYPE_METTERS => 'meters',
            ),
            'fuel_watter_type' => array(
                self::WATTER_TYPE_GALLON => 'gallon',
                self::WATTER_TYPE_LITER => 'liter',
            ),
            'electric_services' => array(
                self::ELECTRIC_SERVICE_30AM => '30amp',
                self::ELECTRIC_SERVICE_50AM => '50amp',
                self::ELECTRIC_SERVICE_100AMPSP => '100amp SP',
                self::ELECTRIC_SERVICE_100AMP3P => '100amp 3P',
                self::ELECTRIC_SERVICE_480V => '480v',
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
}
