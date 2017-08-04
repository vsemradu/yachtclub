<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use kartik\file\FileInput;
use common\models\UserPin;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\LocalInfo */

$this->title = $model->area_name;

?>

<?=
$this->render('_map', [
    'model' => $model,
]);

?>



<br>

<?=
$this->render('_menu', [
    'model' => $model,
]);

?>


<section class="container create-pin">


    <?php Pjax::begin(['id' => 'js-pin-types']); ?>
    <ul id="js-pins-type" class="pins-list">
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_ANCHORAGES . '"><span class="ico">' . Html::img('../img/pin_icons/1.png') . ' </span> ' . \Yii::t('localInfo', 'Anchorage') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_ANCHORAGES, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_MOORINGS . '"><span class="ico">' . Html::img('../img/pin_icons/2.png') . ' </span> ' . \Yii::t('localInfo', 'Moorings') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_MOORINGS, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_DIVESITE . '"><span class="ico">' . Html::img('../img/pin_icons/3.png') . ' </span> ' . \Yii::t('localInfo', 'Dive Site') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_DIVESITE, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_SNORKELSPOT . '"><span class="ico">' . Html::img('../img/pin_icons/4.png') . ' </span> ' . \Yii::t('localInfo', 'Snorkel Spot') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_SNORKELSPOT, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_SURFSPOT . '"><span class="ico">' . Html::img('../img/pin_icons/5.png') . ' </span> ' . \Yii::t('localInfo', 'Surf Spot') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_SURFSPOT, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_FUEL . '"><span class="ico">' . Html::img('../img/pin_icons/6.png') . ' </span> ' . \Yii::t('localInfo', 'Fuel') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_FUEL, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_MARINA . '"><span class="ico">' . Html::img('../img/pin_icons/7.png') . ' </span> ' . \Yii::t('localInfo', 'Marina') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_MARINA, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_WARNING . '"><span class="ico">' . Html::img('../img/pin_icons/8.png') . ' </span> ' . \Yii::t('localInfo', 'Warning') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_WARNING, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_OTHER . '"><span class="ico">' . Html::img('../img/pin_icons/9.png') . ' </span> ' . \Yii::t('localInfo', 'Other') . '</li>', ['view-nautic-navigation', 'type_id' => UserPin::TYPE_OTHER, 'id' => $model->id], ['data-pjax' => '#js-form']) ?>
    </ul>


    <h2 class="h2-title lined">
        <?= UserPin::itemAlias('type_name', $type_id) ?>
    </h2>
    <div class="clubs  js-form">


        <?php foreach ($pinsList as $pin) { ?>
            <div class="item">
                <div class="head">
                    <a data-pjax="0" target="_blank" href="/pin/view?id=<?= $pin->id ?>"><span class="name"> <?= $pin->pinField->name ?></span></a>
                    <?php
                    echo StarRating::widget(['model' => $pin->pinField, 'attribute' => 'rating',
                        'pluginOptions' => [
                            'disabled' => true,
                            'showClear' => false,
                            'step' => 1,
                            'showCaption' => false,
                            'glyphicon' => false,
                            'symbol' => '',
                        ],
                        'options' => [
                            'id' => uniqid()
                        ]
                    ]);

                    ?>
                </div>
                <div class="text">
                    <?= $pin->pinField->summary ?>
                </div>
            </div>
        <?php } ?>
        <?php if (empty($pinsList)) { ?>
            <?php echo \Yii::t('localInfo', ' There is no pins of this type yet') ?>
        <?php } ?>

    </div>
    <script>
        $(document).ready(function () {
            removeMarkers();
            pins = <?= !empty($pins) ? $pins : '""' ?>;
            addMarkers();


            $('.js-type-pin').removeClass("active");
            $('#js-type-<?= $type_id ?>').addClass('active');
        });
    </script>

    <?php Pjax::end(); ?>
    <?php if (!empty(Yii::$app->user->id)) { ?>
        <div class="text-center offset-bottom-default">
            <a href="#" id="js-drop-pin" class="blue-btn"><?= \Yii::t('home', 'DROP PIN'); ?></a>
        </div>
    <?php } ?>
</section>
