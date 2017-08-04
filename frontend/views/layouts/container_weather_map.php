<?php
use yii\helpers\Html;

?>
<div class="container-fluid weather-info">
    <p class="text-center coord-title">
        <?= $lat?>  S  /  <?= $lng?>  E
    </p>
    <div class="row">
    <ul class="clearfix">

        <?php foreach ($data_weather as $weather) { ?>
            <li>
            <p class="wave-title">
                <?= $weather['date'] ?>
            </p>
            <span class="num"><span><?= \Yii::t('google', 'Current Temp:'); ?> </span><?= $weather['tempC'] ?>°C</span>
            <?php if (!empty($weather['averageTemperature'])) { ?>
                <span class="num"><span><?= \Yii::t('google', 'Average Temp:'); ?> </span><?= $weather['averageTemperature'] ?>°</span>
            <?php } ?>

            <?php if (!empty($weather['icon'])) { ?>
                <span class="num"><img src="<?= $weather['icon'] ?>"></span>
            <?php } ?>


            <?php if (!empty($weather['swellDirection'])) { ?>
                <span class="num"><span><?= \Yii::t('google', 'Swell Direction:'); ?></span><?= $weather['swellDirection'] ?><i class="fa fa-long-arrow-down <?= strtolower($weather['swellDirection'])?>"></i></span>
            <?php } ?>
            <?php if (!empty($weather['windDirection'])) { ?>
                <span class="num"><span><?= \Yii::t('google', 'Wind Direction:'); ?></span><?= $weather['windDirection'] ?><i class="fa fa-long-arrow-down <?= strtolower($weather['windDirection'])?>"></i></span>
            <?php } ?>

            <?php if (!empty($weather['windSpeed'])) { ?>
                <span class="num"><span><?= \Yii::t('google', 'Wind speed:'); ?></span><?= $weather['windSpeed'] ?> <span>km</span></span>
            <?php } ?>


            </li>
        <?php } ?>
        
    </ul>
        </div>
    <div class="text-center">
       <a class="blue-btn" href="/site/weather-info?lat=<?= $lat ?>&lng=<?= $lng ?>"><?= \Yii::t('google', 'Detail'); ?>
    </div>
    
    
</div>
