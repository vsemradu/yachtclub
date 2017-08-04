<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="popup-search-body">
    <?php if (!empty($modelLocalInfos)) { ?>

        <p class="popup-serch-title"><?= \Yii::t('search', 'Local pages'); ?></p>
        <div class="clearfix">
            <?php foreach ($modelLocalInfos as $modelLocalInfo) { ?>

                <?= Html::a($modelLocalInfo->area_name, ['local-info/view', 'id' => $modelLocalInfo->id]) ?>
            <?php } ?>
            <hr>
        </div>

    <?php } ?>


    <?php if (!empty($modelYachts)) { ?>

        <p class="popup-serch-title"> <?= \Yii::t('search', 'Yachts'); ?></p>

        <div class="clearfix">
            <?php foreach ($modelYachts as $modelYacht) { ?>

                <?= Html::a($modelYacht->name, ['yacht/view', 'id' => $modelYacht->id]) ?>
            <?php } ?>
            <hr>
        </div>
    <?php } ?>


    <?php if (!empty($modelBusiness)) { ?>

        <p class="popup-serch-title"><?= \Yii::t('search', 'Busineses'); ?></p>
        <div class="clearfix">

            <?php foreach ($modelBusiness as $modelBusines) { ?>

                <?= Html::a($modelBusines->business_name, ['busines/view', 'id' => $modelBusines->id]) ?>
            <?php } ?>
            <hr>
        </div>
    <?php } ?>


    <?php if (!empty($modelPinFields)) { ?>

        <p class="popup-serch-title"><?= \Yii::t('search', 'Pins'); ?></p>

        <div class="clearfix">
            <?php foreach ($modelPinFields as $modelPinField) { ?>

                <?= Html::a($modelPinField->name, ['pin/view', 'id' => $modelPinField->pin_id]) ?>
            <?php } ?>
        </div>
    <?php } ?>

</div>

