<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use kartik\file\FileInput;
use common\models\UserPin;
use yii\widgets\Pjax;
use common\models\Busines;

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
<?php Pjax::begin(['id' => 'js-business-types']); ?>
<section class="container-fluid local-gray">
    <div class="row">
        <div class="container">


            <?php foreach (Busines::itemAlias('type_title') as $key => $type_title) { ?>
                <?php if ($key != Busines::TYPE_PORT) { ?>
                    <a data-pjax='#js-form' href="/local-info/view-business-services?id=<?= $model->id ?>&type_id=<?= $key ?>">

                        <?= Html::img("../img/create_icons/" . $key . ".png") ?>
                        <span><?= $type_title ?> </span>

                    </a>
                <?php } ?>
            <?php } ?>

        </div>
    </div>
</section>

<section class="container create-pin" id="js-form">


    <h2 class="h2-title lined">
        <?= Busines::itemAlias('type_title', $type_id) ?>
    </h2>
    <div class="clubs">

        <?php foreach ($businesList as $busines) { ?>

            <div class="item">
                <div class="head">
                    <span class="name">   <?= $busines->business_name ?></span>
                    <?php
                    echo StarRating::widget(['model' => $busines, 'attribute' => 'rating',
                        'pluginOptions' => [
                            'disabled' => true,
                            'showClear' => false,
                            'step' => 1,
                            'showCaption' => false,
                            'glyphicon' => false,
                            'symbol' => '',
                        ],
                        'options'=>[
                            'id'=>  uniqid(),
                        ]
                    ]);

                    ?>
                </div>
                <div class="text">
                    <p>
                        <?= \Yii::t('business', 'Phone:'); ?>  <?= $busines->phone ?>
                    </p>
                </div>
                <div class="text">
                    <p>
                        <?= \Yii::t('business', 'Address:'); ?> <?= $busines->address ?>
                    </p>
                </div>
                <div class="text">
                    <a data-pjax="0" target="_blank" href="/busines/view?id=<?= $busines->id ?>"><span class="blue"> <?= \Yii::t('business', 'See Business Page'); ?></span></a>
                </div>

            </div>
        <?php } ?>

        <?php if (empty($businesList)) { ?>
            <?= \Yii::t('business', 'There are no bisunesses of this type yet'); ?>
        <?php } ?>
        <?php if (!empty(Yii::$app->user->id)) { ?>
            <div class="text-center">
                <a href="/busines/type" class="blue-btn"><?= \Yii::t('business', 'ADD A BUSINESS'); ?></a>
            </div>
        <?php } ?>
    </div>
</section>

<script>
    $(document).ready(function () {
        removeBusinessMarkers();
        business = <?= !empty($business) ? $business : '""' ?>;
        addBusinessMarkers();
    });
</script>
<?php Pjax::end(); ?>