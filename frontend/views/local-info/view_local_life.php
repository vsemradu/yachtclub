<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use kartik\file\FileInput;
use common\models\BusinessHappyHour;
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



<section class="container reviews-block">


    <?php if (Yii::$app->user->id) { ?>
        <a href="#" class="add-review-btn js-add-comment">
            <?= \Yii::t('localInfo', '+ Leave a Tip or Trick '); ?>
        </a>


        <div class="js-add-comment-block container add-reviews" style="<?php echo!empty($localInfoComment->user_id) ? '' : 'display: none;'; ?>">

            <?php
            $form = ActiveForm::begin([
                    'validateOnSubmit' => true,
            ]);

            ?>
            <div class="form-group">
                <?= $form->field($localInfoComment, 'text')->textarea(['rows' => "5", 'class' => 'form-control input-lg', 'placeholder' => 'Tip or Trick'])->label(false) ?>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="blue-btn"><?= \Yii::t('localInfo', 'Submit'); ?></button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php } ?>



    <?php if (!empty($dataProviderLocalInfoComment->totalCount)) { ?>
        <div class="comments">
            <p class="title">
                <?= \Yii::t('localInfo', 'TIPS & TRICKS'); ?>  
            <sm>
                <?= $dataProviderLocalInfoComment->totalCount ?>   <?= \Yii::t('localInfo', 'tips & tricks'); ?></sm>
            </p>
        </div>
        <div class="blog-post-comments">
            <?php \yii\widgets\Pjax::begin(['id' => 'localInfo-comments']); ?>
            <?=
            yii\widgets\ListView::widget([
                'dataProvider' => $dataProviderLocalInfoComment,
                'itemView' => '_localInfo_view_comments',
                'layout' => "{items}\n{pager}",
            ]);

            ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    <?php } ?>



</section>

<?php Pjax::begin(['id' => 'week']); ?>
<section class="container-fluid blue-section-second second">
    <div class="row">
        <section class="container create-pin">


            <h2 class="h2-title lined">
                <?= \Yii::t('business', 'Happy Hours'); ?>
            </h2>

            <div class="week">
                <?php foreach (BusinessHappyHour::itemAlias('week_title') as $k => $week_title) { ?>
                    <?= Html::a($week_title, ['view-local-life', 'week_id' => $k, 'id' => $model->id], ['data-pjax' => '#js-week', 'class' => ($week_id == $k) ? 'active' : '']) ?>
                <?php } ?>
            </div>

            <div id="js-week" class="clubs">



                <?php foreach ($businessHappyHours as $businessHappyHour) { ?>
                    <div class="item">

                        <div class="head">
                            <span class="name"><?= $businessHappyHour->busines->business_name ?></span>
                            <?php
                            echo StarRating::widget([
                                'name' => 'average_rating',
                                'value' => $businessHappyHour->busines->averageRating,
                                'pluginOptions' => [
                                    'disabled' => true,
                                    'showClear' => false,
                                    'step' => 1,
                                    'showCaption' => false,
                                    'glyphicon' => false,
                                    'symbol' => '',
                                ],
                                'options' => [
                                    'id' => uniqid(),
                                ]
                            ]);

                            ?>
                        </div>
                        <?php if (!empty($businessHappyHour->busines->phone)) { ?>
                            <div class="text">
                                <?= \Yii::t('business', 'Phone:'); ?> <span class="black"><?= $businessHappyHour->busines->phone ?></span>
                            </div>
                        <?php } ?>

                        <?php if (!empty($businessHappyHour->busines->address)) { ?>
                            <div class="text">
                                <?= \Yii::t('business', 'Address:'); ?> <span class="black"><?= $businessHappyHour->busines->address ?></span>
                            </div>
                        <?php } ?>


                        <div class="text">
                            <a data-pjax="0" target="_blank" href="/busines/view?id=<?= $businessHappyHour->busines->id ?>"><span class="blue"><?= \Yii::t('business', 'See Business Page'); ?></span></a>
                        </div>
                        <div class="text">
                            <?= \Yii::t('business', 'Special:'); ?> <span class="black"><?= $businessHappyHour->special ?></span>
                        </div>
                    </div>
                <?php } ?>

                <?php if (empty($businessHappyHours)) { ?>
                    <div class="item">
                        <div class="text">
                            <?= \Yii::t('business', 'There are no specials for this day.'); ?>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </section>
    </div>
</section>
<?php Pjax::end(); ?>


<?php if (!empty($model->localInfoBusinesLocal)) { ?>
    <section class="container local-people">
        <p class="title">
            <?= \Yii::t('localInfo', 'Featured Business'); ?>
        </p>
        <div class="local-people-list">
            <?php foreach ($model->localInfoBusinesLocal as $localInfoBusinesLocal) { ?>
                <div class="human">
                    <a target="_blank" href="/busines/view?id=<?= $localInfoBusinesLocal->busines->id ?>">
                        <div class="photo">
                            <?php if (!empty($localInfoBusinesLocal->busines->businessImageFon)) { ?>

                                <img src="<?= $localInfoBusinesLocal->busines->businessImageFon->imageUrl ?>" alt="">

                            <?php } ?>

                        </div>
                    </a>
                    <a target="_blank" href="/busines/view?id=<?= $localInfoBusinesLocal->busines->id ?>">
                        <?= $localInfoBusinesLocal->busines->business_name ?>
                    </a>
                    <?php
                    echo StarRating::widget(['model' => $localInfoBusinesLocal->busines, 'attribute' => 'rating',
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




<script>
    $(function () {
        $('.js-add-comment').click(function (event) {
            $('.js-add-comment-block').show();
            event.preventDefault();
        });

        $(document).on('click', ".js-delete-comment-localInfo", function (event) {
            block = $(this);
            $.get($(block).attr('href')).done(function (data) {
                if (data == 'true') {
                    $(block).parents('.comment').remove();
                    alert('Tip & Trick has been deleted');
                    $.pjax.reload({container: "#localInfo-comments"});
                }
            });
            event.preventDefault();
        });
    });
</script>