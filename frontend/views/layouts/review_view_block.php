<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\UserPin;
use common\models\Reviews;
use kartik\rating\StarRating;
use kartik\file\FileInput;
use common\models\ReviewReply;

?>
<div class="comment-item js-review-block">
    <div class="media">
        <div class="media-left">
            <div class="photo">
                <?php if (!empty($model->user->userInfo->imageUrl)) { ?>
                    <img alt="" src="<?= $model->user->userInfo->imageUrl ?>">
                <?php } ?>
            </div>
        </div>
        <div class="media-body">
            <p class="blue-row">
                <?= $model->user->userInfo->fullName ?>
            </p>
            <div class="gray-row">
                <?= $model->dateCreate ?>
            </div>

            <?=
            StarRating::widget(['model' => $model, 'attribute' => 'rating',
                'pluginOptions' => [
                    'disabled' => true,
                    'showClear' => false,
                    'step' => 1,
                    'showCaption' => false,
                    'glyphicon' => false,
                    'symbol' => '',
                    'id' => uniqid('rating'),
                ],
                'options' => [
                    'id' => uniqid('rating'),
                ]
            ]);

            ?>


            <div class="text">
                <b><?= $model->title; ?></b><br>
                <?= $model->text; ?>
            </div>
            <?php if (!empty($model->reviewImage)) { ?>
                <div class="review-slider">
                    <div class="slider-review">

                        <?php foreach ($model->reviewImage as $reviewImage) { ?>
                            <div class="item">
                                <img src="<?= $reviewImage->image->imageUrl ?>" alt="">
                            </div>
                        <?php } ?>



                    </div>
                </div>
            <?php } ?>


            <?php if ($model->type == Reviews::TYPE_PIN) { ?>


                <div class="rating-choose-sm" style="<?= empty($model->weather) ? 'display:none;' : '' ?>">
                    <div class="label-rating">
                        Weather
                    </div>
                    <?= $model->weather ?>
                </div>


                <div class="rating-choose-sm"  style="<?= empty($model->sea_swell) ? 'display:none;' : '' ?>">
                    <div class="label-rating">
                        Sea Swell
                    </div>
                    <?= $model->sea_swell ?>
                </div>
                <div class="rating-choose-sm"  style="<?= empty($model->wind_direction) ? 'display:none;' : '' ?>">
                    <div class="label-rating">
                        Wind Direction
                    </div>
                    <?= $model->wind_direction ?>
                </div>
                <br>


                <?php if (!empty($model->vessel_name) OR ! empty($model->vessel_draft) OR ! empty($model->vessel_lenght) OR ! empty($model->vessel_beam) OR ! empty($model->vessel_air_draft) OR ! empty($model->vessel_sail)) { ?>
                    <div class="rating-choose-sm">
                        <div class="label-rating black">
                            Vessel Information
                        </div>
                    </div>
                    <div class="rating-choose-sm" style="<?= empty($model->vessel_name) ? 'display:none;' : '' ?>">
                        <div class="label-rating">
                            Name
                        </div>
                        <?= $model->vessel_name ?>
                    </div>
                    <div class="rating-choose-sm" style="<?= empty($model->vessel_draft) ? 'display:none;' : '' ?>">
                        <div class="label-rating">
                            Draft
                        </div>
                        <?= $model->vessel_draft ?>
                    </div>
                    <div class="rating-choose-sm" style="<?= empty($model->vessel_lenght) ? 'display:none;' : '' ?>">
                        <div class="label-rating">
                            Lenght
                        </div>
                        <?= $model->vessel_lenght ?>
                    </div>
                    <div class="rating-choose-sm" style="<?= empty($model->vessel_beam) ? 'display:none;' : '' ?>">
                        <div class="label-rating">
                            Beam
                        </div>
                        <?= $model->vessel_beam ?>
                    </div>
                    <div class="rating-choose-sm" style="<?= empty($model->vessel_air_draft) ? 'display:none;' : '' ?>">
                        <div class="label-rating">
                            Air Draft
                        </div>
                        <?= $model->vessel_air_draft ?>
                    </div>
                    <div class="rating-choose-sm" style="<?= empty($model->vessel_sail) ? 'display:none;' : '' ?>">
                        <div class="label-rating">
                            Sail/Power
                        </div>
                        <?= $model->vessel_sail ?>
                    </div>


                <?php } ?>
            <?php } ?>
            <?php if ($model->type == Reviews::TYPE_YACHT) { ?>
                <div class="rating-choose-sm">
                    <div class="label-rating black">
                        Family trip
                    </div>
                </div>

                <div class="rating-choose-sm">
                    <div class="label-rating">
                        Crew
                    </div>
                    <?=
                    StarRating::widget(['model' => $model, 'attribute' => 'rating_crew',
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
                            'id' => uniqid('rating'),
                        ]
                    ]);

                    ?>
                </div>
                <div class="rating-choose-sm">
                    <div class="label-rating">
                        Cleanliness
                    </div>
                    <?=
                    StarRating::widget(['model' => $model, 'attribute' => 'rating_cleanliness',
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
                            'id' => uniqid('rating'),
                        ]
                    ]);

                    ?>
                </div>
                <div class="rating-choose-sm">
                    <div class="label-rating">
                        Enjoyability
                    </div>
                    <?=
                    StarRating::widget(['model' => $model, 'attribute' => 'rating_enjoyability',
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
                            'id' => uniqid('rating'),
                        ]
                    ]);

                    ?>
                </div>
                <div class="rating-choose-sm">
                    <div class="label-rating">
                        Maintenance - boat up keep
                    </div>
                    <?=
                    StarRating::widget(['model' => $model, 'attribute' => 'rating_maintenance',
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
                            'id' => uniqid('rating'),
                        ]
                    ]);

                    ?>
                </div>
            <?php } ?>


            <?php if (!empty(Yii::$app->user->id) && $model->user_id == Yii::$app->user->id) { ?>
                <a class="js-delete-review blue-btn" href="<?= Url::toRoute(['/site/ajax-delete-review', 'id' => $model->id]) ?>"> <?= \Yii::t('blog', 'Delete'); ?> </a>
            <?php } ?>



            <?php if ($model->type == Reviews::TYPE_YACHT) { ?>
                <?php if (!empty(Yii::$app->user->id) && $model->user_id != Yii::$app->user->id && $model->yacht->user_id == Yii::$app->user->id) { ?>
                    <a class="js-reply-review blue-btn" href="#"> <?= \Yii::t('blog', 'Reply'); ?> </a>
                <?php } ?>
            <?php } ?>


            <?php if ($model->type == Reviews::TYPE_BUSINESS) { ?>
                <?php if (!empty(Yii::$app->user->id) && $model->user_id != Yii::$app->user->id && $model->business->user_id == Yii::$app->user->id) { ?>
                    <a class="js-reply-review blue-btn" href="#"> <?= \Yii::t('blog', 'Reply'); ?> </a>
                <?php } ?>

            <?php } ?>


            <div class="js-add-reviewReply-block" style="display: none;">

                <?php
                $reviewReply = new ReviewReply();
                $form = ActiveForm::begin([
                        'validateOnSubmit' => true,
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => false,
                ]);

                ?>

                <div class="form-group">
                    <?= $form->field($reviewReply, 'text')->textarea(['rows' => "5", 'class' => 'form-control input-lg', 'placeholder' => 'Text'])->label(false) ?>
                </div>
                <?= $form->field($reviewReply, 'review_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="blue-btn"><?= \Yii::t('reviews', 'Submit'); ?></button>
                        <button type="button" class="js-reviewReply-cancel blue-btn"><?= \Yii::t('reviews', 'Cancel'); ?></button>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>


            <?php if (!empty($model->reviewReply)) { ?>  
                <hr>
                <?php foreach ($model->reviewReply as $reviewReply) { ?>
                    <div class="media js-reviewReply-block">
                        <div class="media-left">
                            <div class="photo">
                                <?php if (!empty($reviewReply->user->userInfo->imageUrl)) { ?>
                                    <img alt="" src="<?= $reviewReply->user->userInfo->imageUrl ?>">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="media-body">
                            <p class="blue-row">
                                <?= $reviewReply->user->userInfo->fullName ?>
                            </p>
                            <div class="gray-row">
                                <?= $reviewReply->dateCreate ?>
                            </div>
                            <div class="text">

                                <?= $reviewReply->text; ?>

                                <?php if (!empty(Yii::$app->user->id) && $reviewReply->user_id == Yii::$app->user->id) { ?>
                                    <br>
                                    <a class="js-delete-reviewReply blue-btn" href="<?= Url::toRoute(['/site/ajax-delete-review-reply', 'id' => $reviewReply->id]) ?>"> <?= \Yii::t('blog', 'Delete'); ?> </a>
                                <?php } ?>
                            </div>
                        </div>


                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>