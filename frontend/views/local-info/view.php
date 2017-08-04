<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use kartik\file\FileInput;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\LocalInfo */

$this->title = $model->area_name;

?>


<?=
$this->render('_map', [
    'model' => $model,
    'map_false' => 1
]);

?>



<section id="down-block" class="container-fluid blue-section-second second">
    <div class="row">
        <div class="container">
            <p class="title">
                <?= $model->area_name ?>
            </p>

            <div class="row">
                <div class="col-md-10">
                    <div class="local-text js-text-localInfo js-text-summary">
                        <?= \Yii::t('localInfo', '<p>Summary</p>'); ?>


                        <span class="js-little"></span>
                        <span class="js-big" style="display: none;">
                            <?= $model->summary ?><a class="js-read-less" href="#"><?= \Yii::t('localInfo', 'Read less'); ?></a>
                        </span>

                    </div>
                </div>


                <?php if (!empty($model->image_id)) { ?>
                    <div class="col-md-2">
                        <div class="photo-flag">
                            <img src="<?= $model->image->imageUrl ?>" class="local-image" alt="">
                        </div>

                    </div>
                <?php } ?>
            </div>
        </div>
</section>

<?=
$this->render('_menu', [
    'model' => $model,
]);

?>


<section class="container-fluid blue-section-second second">

    <p class="title">
        <?= \Yii::t('localInfo', 'Photo'); ?>
    </p>

    <div class="row">
        <div class="container">
            <?php if (!empty($model->localInfoImage)) { ?>
                <div class="slider-bus">
                    <?php foreach ($model->localInfoImage as $localInfoImage) { ?>
                        <div class="item">
                            <img src="<?= $localInfoImage->image->imageUrl ?>" alt="">
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <?php if (!empty(Yii::$app->user->id)) { ?>
                    <div class="text-center">
                        There is no photos of this place yet. Be the first to share them! 
                    </div>

                    <br><br>
                <?php } ?>
            <?php } ?>


            <?php if (!empty(Yii::$app->user->id)) { ?>
                <div class="text-center">
                    <button onclick="$('#js-upload-photo').modal('show');" class="blue-btn"><?= \Yii::t('localInfo', 'Upload'); ?></button>
                </div>
            <?php } ?>

        </div>
    </div>

</section>

<?php if (!empty(Yii::$app->user->id)) { ?>
    <?php
    Modal::begin([
        'header' => '<h4>Upload</h4>',
        'toggleButton' => false,
        'id' => 'js-upload-photo'
    ]);

    ?>

    <?php
    $form = ActiveForm::begin([
            'id' => 'pin-form',
            'options' => ['enctype' => 'multipart/form-data']
    ]);

    ?>
    <div class="row">
        <div class="col-md-12 text-right">
            <?=
            $form->field($image, 'upload_image[]')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                    'id' => uniqid()
                ],
                'pluginOptions' => [
                    'showRemove' => false,
                    'showUpload' => false,
                ],
            ])->label(false);

            ?>
            <br>
            <div class="text-center">
                <button class="blue-btn"><?= \Yii::t('localInfo', 'Upload'); ?></button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <?php
    Modal::end();

    ?>
<?php } ?>
<?php if (!empty($model->localInfoBusinesFeature)) { ?>
    <section class="container local-people">
        <p class="title">
            <?= \Yii::t('localInfo', 'Featured Business'); ?>
        </p>
        <div class="local-people-list">
            <?php foreach ($model->localInfoBusinesFeature as $localInfoBusinesFeature) { ?>
                <div class="human">
                    <a target="_blank" href="/busines/view?id=<?= $localInfoBusinesFeature->busines->id ?>">
                        <div class="photo">
                            <?php if (!empty($localInfoBusinesFeature->busines->businessImageFon)) { ?>

                                <img src="<?= $localInfoBusinesFeature->busines->businessImageFon->imageUrl ?>" alt="">

                            <?php } ?>

                        </div>
                    </a>
                    <a target="_blank" href="/busines/view?id=<?= $localInfoBusinesFeature->busines->id ?>">
                        <?= $localInfoBusinesFeature->busines->business_name ?>
                    </a>
                    <?php
                    echo StarRating::widget(['model' => $localInfoBusinesFeature->busines, 'attribute' => 'rating',
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

            <?php } ?>
        </div>
    </section>
<?php } ?>

<script type="text/javascript">
    $(function () {
        var summary = <?= $model->summaryJson ?>;
        var summary = htmlTexttruncate(summary.data);
        $('.js-text-summary span.js-little').html(summary);
    });
</script>