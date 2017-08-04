<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\UserPin;
use common\models\PinField;
use common\models\Reviews;
use kartik\rating\StarRating;

?>
<!-- rec page -->
<a href="/site/index">
    <div class="header-map large"></div>
</a>

<section class="container single-pins">
    <h2 class="h2-title lined">
        <?= UserPin::itemAlias('type_name', $pin->type) ?>
    </h2>

    <div class="row">
        <div class="col-md-7">
            <p class="title">
                <?= $pin->pinField->name ?>
            </p>


            <?php if ($pin->pinField->rating) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Avarage Rating:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?php
                        echo StarRating::widget([
                            'name' => 'average_rating',
                            'value' => $pin->averageRating,
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
                    </div>
                </div>
            <?php } ?>



            <div class="media">
                <div class="media-left">
                    <span class="gray">
                        <?= \Yii::t('pin', 'GPS Coordinates:'); ?>
                    </span>
                </div>
                <div class="media-body">
                    <?= $pin->latConvert ?> S / <?= $pin->lanConvert ?> E
                </div>
            </div>


            <?php if (!empty($pin->pinField->ratingList)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Rating:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->ratingList ?>
                    </div>
                </div>
            <?php } ?>


            <?php if (!empty($pin->pinField->location)) { ?>

                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Location:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->location ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($pin->pinField->breakList)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Break:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->breakList ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($pin->pinField->max_depth)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Max. Depth:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->max_depth ?> <?= PinField::itemAlias('vessel_type', $pin->pinField->max_depth_type) ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($pin->pinField->visibilityList)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Visibility:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->visibilityList ?>
                    </div>
                </div>
            <?php } ?>


            <?php if (!empty($pin->pinField->dive_operator_name)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', ' Dive Operator Name:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->dive_operator_name ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($pin->pinField->dive_operator_address)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', ' Dive Operator Address:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->dive_operator_address ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (!empty($pin->pinField->vessel_lenght)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', ' Max. Vessel Length:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->vessel_lenght ?> <?= PinField::itemAlias('vessel_type', $pin->pinField->vessel_lenght_type) ?>
                    </div>
                </div>
            <?php } ?>


            <?php if (!empty($pin->pinField->vessel_draft)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', ' Max. Vessel Draft:'); ?> 
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->vessel_draft ?> <?= PinField::itemAlias('vessel_type', $pin->pinField->vessel_draft_type) ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($pin->pinField->quality_rating)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Fuel Quality Rating:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->qualityRatingList ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($pin->pinField->resourcesWithinList)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Resources within a short tender ride:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->resourcesWithinList ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($pin->pinField->electricServices)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Electric Services (US):'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->electricServices ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($pin->pinField->electricity_price)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Electricity Price:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->electricity_price ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($pin->pinField->dockage_price)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Dockage Price:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->dockage_price ?> <?= PinField::itemAlias('vessel_type', $pin->pinField->dockage_price_type) ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (!empty($pin->pinField->fuel_price)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Fuel Price:'); ?>
                        </span>
                    </div>
                    <div class="media-body"> 
                        <?= $pin->pinField->fuel_price ?> <?= PinField::itemAlias('fuel_watter_type', $pin->pinField->fuel_price_type) ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($pin->pinField->water_price)) { ?>

                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Water Price:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->water_price ?> <?= PinField::itemAlias('fuel_watter_type', $pin->pinField->water_price_type) ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($pin->pinField->swell_hight)) { ?>


                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Swell hight:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->swell_hight ?> <?= PinField::itemAlias('vessel_type', $pin->pinField->swell_hight_type) ?>

                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($pin->pinField->swell_direction)) { ?>


                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Swell direction:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->swell_direction ?> 

                    </div>
                </div>
            <?php } ?>



            <?php if (!empty($pin->pinField->howSevereList)) { ?>
                <div class="media">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'How severe:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->howSevereList ?>

                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($pin->pinField->summary)) { ?>
                <div class="media wrap">
                    <div class="media-left">
                        <span class="gray">
                            <?= \Yii::t('pin', 'Summary:'); ?>
                        </span>
                    </div>
                    <div class="media-body">
                        <?= $pin->pinField->summary ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($pin->pinField->reefPointBeachBreak)) { ?>
                <div class="media wrap">
                   
                    <div class="media-body">
                        <?= $pin->pinField->reefPointBeachBreak ?>
                    </div>
                </div>
            <?php } ?>


        </div>
        <?php if (!empty($pin->images)) { ?>
            <div class="col-md-5">
                <div class="photo-slider">
                    <?php foreach ($pin->images as $images) { ?>

                        <div class="item">
                            <img src="<?= $images->image->imageUrl ?>" alt="">
                        </div>
                    <?php } ?>
                </div>
                <?php if (count($pin->images) > 1) { ?>
                    <div class="slider-navigation">
                        <i class="fa fa-chevron-left"></i>
                        <i class="fa fa-chevron-right"></i>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<section class="container single-pins-comments">
    <p class="title">
        <?= \Yii::t('pin', 'Comments and Tips:'); ?>
    </p>
    <?= $pin->description ?>
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($pin->user->userInfo->imageUrl)) { ?>
                <div class="photo" style="background:url(<?= $pin->user->userInfo->imageUrl ?>)no-repeat center;background-size:cover;"></div>
            <?php } else { ?>
                <div class="photo"></div>
            <?php } ?>

            <span class="gray">
                <?= \Yii::t('pin', 'Rating Pin by:'); ?>
            </span>

            <div class="rating-inline">
                <span>
                    <?= $pin->user->userInfo->fullName ?>
                </span>
            </div>

            <div class="rating-inline">
                <?=
                StarRating::widget(['model' => $pin->pinField, 'attribute' => 'rating',
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
            </div>

            <ul class="gray-text-bordered">

                <?php if (!empty($pin->pinField->warnings)) { ?>
                    <li><span class="gray"><?= \Yii::t('pin', 'Warnings:'); ?></span> <?= $pin->pinField->warnings ?></li>
                <?php } ?>
                <?php if (!empty($pin->pinField->sea_swell)) { ?>
                    <li><span class="gray"><?= \Yii::t('pin', 'Sea Swell:'); ?></span> <?= $pin->pinField->sea_swell ?></li>
                <?php } ?>

                <?php if (!empty($pin->pinField->wind_direction)) { ?>
                    <li><span class="gray"><?= \Yii::t('pin', 'Wind Direction:'); ?></span> <?= $pin->pinField->wind_direction ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="textarea">
        <?= $pin->description ?>
    </div>
</section>

<?php if (!empty($pin->pinVessel->id) && (!empty($pin->pinVessel->vessel_name) OR ! empty($pin->pinVessel->vessel_draft OR ! empty($pin->pinVessel->vessel_lengh) OR ! empty($pin->pinVessel->vessel_beam) OR ! empty($pin->pinVessel->vessel_air_draft) OR ! empty($pin->pinVessel->vessel_sail)))) { ?>
    <section class="container-fluid blue-block">
        <div class="row">
            <div class="container">
                <div class="col-md-4 vcenter">
                    <p class="title">
                        <?= \Yii::t('pin', 'Vessel information'); ?>
                    </p>

                    <p style="<?= !empty($pin->pinVessel->vessel_name) ? '' : 'display: none;' ?>"><?= \Yii::t('pin', 'Name:'); ?> <?= $pin->pinVessel->vessel_name ?></p>
                    <p style="<?= !empty($pin->pinVessel->vessel_draft) ? '' : 'display: none;' ?>"><?= \Yii::t('pin', 'Draft:'); ?> <?= $pin->pinVessel->vessel_draft ?></p>
                    <p style="<?= !empty($pin->pinVessel->vessel_lenght) ? '' : 'display: none;' ?>"><?= \Yii::t('pin', 'Lenght:'); ?> <?= $pin->pinVessel->vessel_lenght ?></p>
                    <p style="<?= !empty($pin->pinVessel->vessel_beam) ? '' : 'display: none;' ?>"><?= \Yii::t('pin', 'Beam:'); ?> <?= $pin->pinVessel->vessel_beam ?></p>
                    <p style="<?= !empty($pin->pinVessel->vessel_air_draft) ? '' : 'display: none;' ?>"><?= \Yii::t('pin', 'Air Draft:'); ?> <?= $pin->pinVessel->vessel_air_draft ?></p>
                    <p style="<?= !empty($pin->pinVessel->vessel_sail) ? '' : 'display: none;' ?>"><?= \Yii::t('pin', 'Sail/Power:'); ?> <?= $pin->pinVessel->vessel_sail ?></p>
                </div>
                <div class="col-md-8 vcenter">
                    <div class="row text-center">
                        <div class="col-sm-4 vcenter">

                            <?php if (!empty($pin->pinVessel->yacht->background_image_id)) { ?>
                                <img src="<?= $pin->pinVessel->yacht->yachtImageFon->imageUrl ?>" class="pin-img-center" alt="">
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>




<section class="container reviews-block">
    <?php if (!empty(Yii::$app->user->id) && $pin->approved == UserPin::APPROVED_TRUE) { ?>
        <?php
        echo $this->render('//layouts/review_form_pin_busines', [
            'reviews' => $reviews,
            'image' => $image,
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

<!-- END rec PAGE -->
