<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\BusinessHappyHour;

?>
<div class="item">
    <div class="text">
        <?= \Yii::t('business', 'Special:'); ?> <span class="black"><?= $model->special ?></span>
    </div>
</div>