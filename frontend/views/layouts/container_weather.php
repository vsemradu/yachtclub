<?php
use yii\helpers\Html;

?>
<div class="js-container-weather container-fluid weather-block">
    <ul>

        <?php foreach ($data_weather as $weather) { ?>
            <li>
            <sm><?= $weather['date'] ?></sm>
            <span class="num"><?= $weather['tempC'] ?>°C</span>
            <?php if (!empty($weather['icon'])) { ?>
                <span class="num"><img src="<?= $weather['icon'] ?>"></span>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>