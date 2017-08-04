<?php
use yii\helpers\Html;
use frontend\helpers\ApiHelper;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Weather detail';

?>

<?php if ($header) { ?>
    <div class="header-map large"></div>
<?php } ?>
<div class="container weather-info">
    <h1>
        <?= ApiHelper::convertCoordinate($lat) ?>  S  /  <?= ApiHelper::convertCoordinate($lng) ?>  E
    </h1>
    <ul class="clearfix">

        <?php foreach ($data_weather as $weather) { ?>
            <li>
                <p class="wave-title">
                    <?= $weather['date'] ?>
                </p>
                <span class="num"><span><?= \Yii::t('google', 'Current Temp:'); ?> </span><?= $weather['tempC'] ?>°C</span>
                <?php if (isset($weather['averageTemperature'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Average Temp:'); ?> </span><?= $weather['averageTemperature'] ?>°C</span>
                <?php } ?>

                <?php if (isset($weather['icon'])) { ?>
                    <span class="num"><img src="<?= $weather['icon'] ?>"></span>
                <?php } ?>


                <?php if (isset($weather['swellDirection'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Swell Direction:'); ?></span><?= $weather['swellDirection'] ?><i class="fa fa-long-arrow-down <?= strtolower($weather['swellDirection']) ?>"></i></span>
                <?php } ?>
                <?php if (isset($weather['windDirection'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Wind Direction:'); ?></span><?= $weather['windDirection'] ?><i class="fa fa-long-arrow-down <?= strtolower($weather['windDirection']) ?>"></i></span>
                <?php } ?>

                <?php if (isset($weather['windSpeed'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Wind speed:'); ?></span><?= $weather['windSpeed'] ?> <span style="font-size: 12px;">km</span></span>
                <?php } ?>
                <?php if (isset($weather['other']['cloudcover'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Cloudcover:'); ?></span><?= $weather['other']['cloudcover'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['DewPointC'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Dew Point:'); ?></span><?= $weather['other']['DewPointC'] ?>°C</span>
                <?php } ?>
                <?php if (isset($weather['other']['FeelsLikeC'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Feels Like:'); ?></span><?= $weather['other']['FeelsLikeC'] ?>°C</span>
                <?php } ?>
                <?php if (isset($weather['other']['HeatIndexC'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Heat Index:'); ?></span><?= $weather['other']['HeatIndexC'] ?>°C</span>
                <?php } ?>
                <?php if (isset($weather['other']['humidity'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Humidity:'); ?></span><?= $weather['other']['humidity'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['swellDir'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Swell Dir:'); ?></span><?= $weather['other']['swellDir'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['swellHeight_m'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Swell Height:'); ?></span><?= $weather['other']['swellHeight_m'] ?> m</span>
                <?php } ?>
                <?php if (isset($weather['other']['swellPeriod_secs'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Swell Period:'); ?></span><?= $weather['other']['swellPeriod_secs'] ?> secs</span>
                <?php } ?>
                <?php if (isset($weather['other']['visibility'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Visibility:'); ?></span><?= $weather['other']['visibility'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['waterTemp_C'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Water Temp:'); ?></span><?= $weather['other']['waterTemp_C'] ?>°C</span>
                <?php } ?>
                <?php if (isset($weather['other']['WindGustKmph'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Wind Gust:'); ?></span><?= $weather['other']['WindGustKmph'] ?> Kmph</span>
                <?php } ?>
                <?php if (isset($weather['other']['windspeedKmph'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Wind Speed:'); ?></span><?= $weather['other']['windspeedKmph'] ?> Kmph</span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceoffog'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of fog:'); ?></span><?= $weather['other']['chanceoffog'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceoffrost'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of frost:'); ?></span><?= $weather['other']['chanceoffrost'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceofhightemp'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of high temp:'); ?></span><?= $weather['other']['chanceofhightemp'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceofovercast'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of over cast:'); ?></span><?= $weather['other']['chanceofovercast'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceofrain'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of rain:'); ?></span><?= $weather['other']['chanceofrain'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceofremdry'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of remdry:'); ?></span><?= $weather['other']['chanceofremdry'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceofsnow'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of snow:'); ?></span><?= $weather['other']['chanceofsnow'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceofsunshine'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of sunshine:'); ?></span><?= $weather['other']['chanceofsunshine'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceofthunder'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of thunder:'); ?></span><?= $weather['other']['chanceofthunder'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['chanceofwindy'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Chance of windy:'); ?></span><?= $weather['other']['chanceofwindy'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['DewPointC'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Dew Point:'); ?></span><?= $weather['other']['DewPointC'] ?>°C</span>
                <?php } ?>
                <?php if (isset($weather['other']['FeelsLikeC'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Feels Like:'); ?></span><?= $weather['other']['FeelsLikeC'] ?>°C</span>
                <?php } ?>
                <?php if (isset($weather['other']['HeatIndexC'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Heat Index:'); ?></span><?= $weather['other']['HeatIndexC'] ?>°C</span>
                <?php } ?>
                <?php if (isset($weather['other']['precipMM'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Precip MM:'); ?></span><?= $weather['other']['precipMM'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['pressure'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Pressure:'); ?></span><?= $weather['other']['pressure'] ?></span>
                <?php } ?>
                <?php if (isset($weather['other']['WindChillC'])) { ?>
                    <span class="num"><span><?= \Yii::t('google', 'Wind Chill:'); ?></span><?= $weather['other']['WindChillC'] ?>°C</span>
                        <?php } ?>




            </li>
        <?php } ?>


    </ul>
</div>
