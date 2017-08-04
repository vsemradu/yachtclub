<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\rating\StarRating;
use common\models\BusinessHappyHour;
use yii\widgets\Pjax;

?>
<section class="full-screen-img">


    <?php if (!empty(Yii::$app->user->id)) { ?>
        <?php if ($model->user_id == Yii::$app->user->id) { ?>
            <a href="/busines/update?id=<?= $model->id ?>" class="edit-btn">
                <i class="fa fa-pencil"></i>
            </a>
        <?php } ?>
    <?php } ?>
    <?php if (!empty($model->businessImageFon)) { ?>
        <img src="<?= $model->businessImageFon->imageUrl ?>" alt="">
    <?php } else { ?>
        <img src="../img/bg-sea.jpg" alt="">
    <?php } ?>
    <div class="full-screen-overlay">
        <div class="fullwidth">
            <p class="title">
                <?= $model->business_name ?>
            </p>

            <?php
            echo StarRating::widget([
                'name' => 'average_rating',
                'value' => $model->averageRating,
                'pluginOptions' => [
                    'disabled' => true,
                    'showClear' => false,
                    'step' => 1,
                    'showCaption' => false,
                    'glyphicon' => false,
                    'symbol' => '',
                ]
            ]);

            ?>

            <div>
                <hr>

                <p class="text">

                    <?php if ($model->type_id == \common\models\Busines::TYPE_OTHER) { ?>
                        <?= $model->type_text ?>
                    <?php } else { ?>
                        <?= \common\models\Busines::itemAlias('type_title', $model->type_id) ?>
                    <?php } ?>
                </p>
            </div>

            <?php if ($model->private == \common\models\Busines::PRIVATE_TRUE) { ?>
                <br><br>
                <div class="single-pins-comments text-center">
                    <?php if (!empty($model->ownerUser->userInfo->imageUrl)) { ?>
                        <div class="photo" style="background:url(<?= $model->ownerUser->userInfo->imageUrl ?>)no-repeat center;background-size:cover;"></div>
                    <?php } else { ?>
                        <div class="photo"></div>
                    <?php } ?>
                    <span class="gray">
                        <?= \Yii::t('business', ' This page is creates by'); ?>
                    </span>
                    <div class="rating-inline">
                        <span>
                            <?= $model->ownerUser->userInfo->fullName ?>
                        </span>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if ($model->owner == \common\models\Busines::OWN_FALSE && !empty(\Yii::$app->user->id)) { ?>
            <div class="absolute-bottom-section js-claim-block">
                <p><?= \Yii::t('business', 'This page is not created by owner but someone who has visited the business or used this business services. If this is your business please sign up and claim it as your own.'); ?></p>

                <a href="#" class="js-claim blue-btn">  <?= \Yii::t('business', 'CLAIM'); ?></a>
            </div>
        <?php } ?>
    </div>
</section>



<section class="container-fluid blue-section-second">
    <div class="row">
        <div class="container">
            <div class="row space-between">

                <?php if (!empty($model->address)) { ?>
                    <div class="col-md-3">
                        <p>
                            <?= \Yii::t('business', 'Address:'); ?> <?= $model->address ?>
                        </p>
                    </div>
                <?php } ?>


                <?php if (!empty($model->phone)) { ?>
                    <div class="col-md-3">
                        <p>
                            <?= \Yii::t('business', 'Phone:'); ?>  <?= $model->phone ?>
                        </p>
                    </div>
                <?php } ?>

                <?php if (!empty($model->website)) { ?>
                    <div class="col-md-3">
                        <p>
                            <?= \Yii::t('business', 'Site:'); ?>  <a target="_blank" href="<?= $model->website ?>"><?= $model->website ?></a>
                        </p>
                    </div>
                <?php } ?>

                <?php if (!empty($model->businessPin->pin->pinField->name)) { ?>
                    <div class="col-md-3">
                        <p>
                            <?= \Yii::t('business', 'Related Pin:'); ?> <a target="_blank" href="/pin/view?id=<?= $model->businessPin->pin->id ?>"><span><?= $model->businessPin->pin->pinField->name ?></span></a>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>


<section class="container single-pins-comments">
    <p class="title">
        <?= \Yii::t('business', 'Summary:'); ?>
    </p>
    <?php if ($model->owner == \common\models\Busines::OWN_FALSE) { ?>
        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($model->ownerUser->userInfo->imageUrl)) { ?>
                    <div class="photo" style="background:url(<?= $model->ownerUser->userInfo->imageUrl ?>)no-repeat center;background-size:cover;"></div>
                <?php } else { ?>
                    <div class="photo"></div>
                <?php } ?>

                <span class="gray">
                    <?= \Yii::t('business', '   Rating by'); ?>
                </span>

                <div class="rating-inline">
                    <span>
                        <?= $model->ownerUser->userInfo->fullName ?>
                    </span>
                </div>

                <div class="rating-inline">
                    <?php
                    echo StarRating::widget(['model' => $model, 'attribute' => 'rating',
                        'pluginOptions' => [
                            'disabled' => true,
                            'showClear' => false,
                            'step' => 1,
                            'showCaption' => false,
                            'glyphicon' => false,
                            'symbol' => '',
                            'id' => uniqid(),
                        ],
                        'options' => [
                            'id' => uniqid(),
                        ]
                    ]);

                    ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="textarea">
        <?= $model->summary ?>
    </div>

    <div class="textarea">

    </div>
</section>


<?php if (!empty($model->businessImages)) { ?>
    <section class="container-fluid blue-section-second second">
        <p class="title">
            <?= \Yii::t('business', 'Photo'); ?>
        </p>
        <div class="row">
            <div class="container">
                <div class="slider-bus">
                    <?php foreach ($model->businessImages as $businessImages) { ?>
                        <div class="item">
                            <img src="<?= $businessImages->image->imageUrl ?>" alt="">
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php if (!empty($model->businessHappyHour)) { ?>
    <?php Pjax::begin(['id' => 'week']); ?>
    <section class="container-fluid blue-section-second second">
        <div class="row">
            <section class="container create-pin">


                <h2 class="h2-title lined">
                    <?= \Yii::t('business', 'Happy Hours'); ?>
                </h2>

                <div class="week">
                    <?php foreach (BusinessHappyHour::itemAlias('week_title') as $k => $week_title) { ?>
                        <?= Html::a($week_title, ['view', 'week_id' => $k, 'id' => $model->id], ['data-pjax' => '#js-week', 'class' => ($week_id == $k) ? 'active' : '']) ?>
                    <?php } ?>
                </div>
                <div id="js-week" class="clubs">

                    <?=
                    yii\widgets\ListView::widget([
                        'dataProvider' => $dataProviderBusinessHappyHours,
                        'itemView' => '_block_happy_hour',
                        'layout' => "{items}\n{pager}",
                        'emptyText' => \Yii::t('business', 'There are no specials for this day.'),
                    ]);

                    ?>


                </div>
            </section>
        </div>
    </section>
    <?php Pjax::end(); ?>
<?php } ?>
<section class="container reviews-block">


    <?php if (!empty(Yii::$app->user->id)) { ?>
        <?php
        echo $this->render('//layouts/review_form_busines', [
            'reviews' => $reviews,
            'rate_two_star' => true,
            'image' => $image,
            'model' => $model,
        ]);

        ?>
    <?php } ?>

    <div class="comments">

        <p class="title">
            <?= \Yii::t('reviews', '  REVIEWS'); ?>
        <sm>
            <?= $dataProviderReviews->count ?>     <?= \Yii::t('reviews', '  reviews'); ?> </sm>
        </p>

    </div>

    <div class="blog-post-comments">
        <?=
        yii\widgets\ListView::widget([
            'dataProvider' => $dataProviderReviews,
            'itemView' => '//layouts/review_view_block',
            'layout' => "{pager}\n{items}\n{pager}",
            'emptyText' => '',
            'id' => 'js-list-review',
        ]);

        ?>
    </div>



</section>



<script>
    $(function () {
        $('.js-claim').click(function (event) {
            if (confirm("Are you sure?")) {
                $.get("/busines/ajax-claim", {business_id: <?= $model->id ?>})
                        .done(function (data) {
                            $('.js-claim-block').remove();

                        });
            }
            event.preventDefault();
        });
    });
</script>
