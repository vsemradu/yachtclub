<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Yacht;
use kartik\rating\StarRating;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Yacht */

$this->title = $model->name;

?>

<section class="full-screen-img yaht">



    <?php if (!empty(Yii::$app->user->id)) { ?>
        <?php if ($model->user_id == Yii::$app->user->id) { ?>
            <a href="/yacht/update?id=<?= $model->id ?>" class="edit-btn">
                <i class="fa fa-pencil"></i>
            </a>
        <?php } ?>
    <?php } ?>
    <?php if (!empty($model->background_image_id)) { ?>
        <img src="<?= $model->yachtImageFon->imageUrl ?>" alt="">
    <?php } ?>

    <p class="wave-title">
        <?= Yacht::itemAlias('subtype_title', $model->subtype) ?>
    </p>

    <div class="full-screen-overlay">
        <p class="name">
            <?= $model->name ?>
        </p>
        <div class="field">
            <p class="gray">
                <?= \Yii::t('yacht', 'Average Rating:'); ?>
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
        </div>
        <div class="field">
            <p class="gray">Size Type:</p>
            <p>60 foot Sail</p>
        </div>

        <?php if (!empty($model->yachtSeason)) { ?>
            <div class="field">
                <p class="gray"><?= \Yii::t('yacht', 'Price/Season/Grounds:'); ?></p>
                <?php foreach ($model->yachtSeason as $yachtSeason) { ?>
                    <p><span><?= $yachtSeason->currency ?><?= $yachtSeason->from ?></span>-<span><?= $yachtSeason->currency ?><?= $yachtSeason->to ?></span> <?= $yachtSeason->season ?></p>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="field">
            <p class="gray">Sleeps:</p>
            <p>Persons / Сabins / Heads</p>
        </div>
        <a href="javascript:;" onclick="$('#inquire').modal('show');
                false;" class="blue-btn">INQUIRE</a>
    </div>
</section>

<section class="container-fluid blue-section-second second">
    <div class="row">
        <div class="container">
            <p class="title">
                <?= \Yii::t('yacht', 'Vessel Info'); ?>
            </p>
            <div class="row vessel-info">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-lg-12">
                            <p>
                                <span class="gray"><?= \Yii::t('yacht', 'Type:'); ?>
                                    <?php if ($model->yacht_type_id == Yacht::TYPE_OTHER) { ?>
                                        <?= $model->yacht_type ?>
                                    <?php } else { ?>
                                        <?= Yacht::itemAlias('type_yacht', $model->yacht_type_id) ?>
                                    <?php } ?>


                                    <?php if ($model->yacht_type_two_id == Yacht::TYPE_OTHER) { ?>
                                        <?= $model->yacht_type ?>
                                    <?php } else { ?>
                                        <?= Yacht::itemAlias('type_yacht_two', $model->yacht_type_two_id) ?>
                                    <?php } ?>
                                </span>
                            </p>
                            <p>
                                <span class="gray"><?= \Yii::t('yacht', 'Year:'); ?> <?= $model->year ?> </span>
                            </p>
                            <p>
                                <span class="gray"><?= \Yii::t('yacht', 'Yacht Build:'); ?> <?= $model->yacht_build ?></span>
                            </p>
                            <p>
                                <span class="gray"><?= \Yii::t('yacht', 'Length:'); ?> <?= $model->length ?></span>
                            </p>
                            <p>
                                <span class="gray"><?= \Yii::t('yacht', 'Draft:'); ?> <?= $model->draft ?></span>
                            </p>
                            <p>
                                <span class="gray"><?= \Yii::t('yacht', 'Air Draft:'); ?> <?= $model->air_draft ?></span>
                            </p>
                            <p>
                                <span class="gray"><?= \Yii::t('yacht', 'Beam:'); ?> <?= $model->beam ?></span>
                            </p>

                            <p>
                                <span class="gray"><?= \Yii::t('yacht', 'Flag/Home Port:'); ?> <?= $model->home_port ?></span>
                            </p>



                            <?php if (\common\models\User::hasBackendAccess()) { ?>
                                <?php if (!empty($model->website)) { ?>

                                    <p>
                                        <span class="gray"><?= \Yii::t('yacht', 'Website:'); ?> <?= $model->website ?></span>
                                    </p>
                                <?php } ?>
                                <?php if (!empty($model->charter_company)) { ?>
                                    <p>
                                        <span class="gray"><?= \Yii::t('yacht', 'Charter Company:'); ?> <?= $model->charter_company ?></span>
                                    </p>
                                <?php } ?>
                                <?php if (!empty($model->contact_info)) { ?>
                                    <p>
                                        <span class="gray"><?= \Yii::t('yacht', 'Charter Broker Name & Contact info:'); ?> <?= $model->contact_info ?></span>
                                    </p>
                                <?php } ?>
                            <?php } ?>
                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid bordered-block">
    <ul class="yaht-list">
        <li>
            <span class="ico">
                <i class="fa fa-cutlery"></i>
            </span>

            <?= \Yii::t('yacht', 'Menu'); ?>    
        </li>
        <?php if ($model->subtype != Yacht::TYPE_CHARTER_BARE && !empty($model->yachtCrews)) { ?>
            <li class="js-scroll-users">
                <span class="ico">
                    <i class="fa fa-users"></i>
                </span>

                <?= \Yii::t('yacht', 'Crew'); ?>   
            </li>
        <?php } ?>
        <li class="js-scroll-star">
            <span class="ico">
                <i class="fa fa-star"></i>
            </span>

            <?= \Yii::t('yacht', 'Reviews'); ?>  
        </li>

        <?php if ($model->enable_blog == Yacht::ENABLE_BLOG_TRUE && !empty($model->yachtBlogs)) { ?>
            <li class="js-scroll-comments">
                <span class="ico">
                    <i class="fa fa-comments"></i>
                </span>

                <?= \Yii::t('yacht', 'Blog'); ?>
            </li>
        <?php } ?>
    </ul>
</section>

<section class="container summary-block">
    <p class="title"><?= \Yii::t('yacht', 'Summary'); ?></p>
    <div class="text">
        <?= $model->summary ?>
    </div>
</section>
<?php if (!empty($model->yachtImages)) { ?>
    <section class="container-fluid blue-section-second second no-title">
        <div class="row">
            <div class="container">
                <div class="slider-bus">
                    <?php foreach ($model->yachtImages as $yachtImages) { ?>
                        <div class="item">
                            <img src="<?= $yachtImages->image->imageUrl ?>" alt="">
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php if ($model->enable_blog != Yacht::TYPE_CHARTER_BARE && !empty($model->yachtCrews)) { ?>
    <section class="container summary-block  js-to-crew">
        <p class="title"><?= \Yii::t('yacht', 'Crew'); ?></p>
        <ul class="people-list">
            <?php foreach ($model->yachtCrews as $yachtCrews) { ?>
                <li>
                    <div class="photo">
                        <?php if (!empty($yachtCrews->crewMember->photo->imageUrl)) { ?>
                            <img src="<?= $yachtCrews->crewMember->photo->imageUrl ?>" alt="">
                        <?php } ?>
                    </div>
                    <p><?= $yachtCrews->crewMember->name ?></p>
                    <p class="blue">
                        <?php
                        if ($yachtCrews->crewMember->role_id == \common\models\CrewMemberRole::TYPE_OTHER) {
                            echo $yachtCrews->crewMember->role;
                        } else {
                            echo $yachtCrews->crewMember->crewRole->name;
                        }

                        ?></p>
                </li>
            <?php } ?>
        </ul>
        <div class="text">
            <?= $model->crew_description ?>  
        </div>
    </section>
<?php } ?>



<?php if ($model->enable_blog == Yacht::ENABLE_BLOG_TRUE && !empty($model->yachtBlogs)) { ?>
    <section class="container-fluid blue-section-second second js-to-blog">
        <div class="row">
            <div class="container">
                <p class="title">
                    <?= \Yii::t('yacht', 'Blog'); ?>
                </p>

                <div class="row">
                    <?php
                    yii\widgets\Pjax::begin();
                    echo yii\widgets\ListView::widget([
                        'dataProvider' => $dataProviderBlogPost,
                        'itemView' => '_blog',
                        'summary' => '',
                    ]);
                    yii\widgets\Pjax::end();

                    ?>






                </div>

            </div>
        </div>
    </section>
<?php } ?>

<section class="container reviews-block js-to-reviews">

    <?php if (!empty(Yii::$app->user->id)) { ?>
        <?php
        echo $this->render('//layouts/review_form_yacht', [
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


<div id="inquire" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?= \Yii::t('yacht', 'Inquire'); ?></h4>
            </div>
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                ?>

                <?= $form->field($modelYachtInquireForm, 'email')->textInput()->label('Your email:') ?>

                <?= $form->field($modelYachtInquireForm, 'phone')->textInput()->label('Your phone number:') ?>


                <p><b> <?= \Yii::t('yacht', 'What dates are you searching for?'); ?></b></p>



                <?=
                DatePicker::widget([
                    'name' => 'YachtInquireForm[date_start]',
                    'type' => DatePicker::TYPE_RANGE,
                    'name2' => 'YachtInquireForm[date_end]',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-M-yyyy'
                    ]
                ]);

                ?>




                <?= $form->field($modelYachtInquireForm, 'people')->textInput()->label('How many people are in your party?') ?>


                <?= $form->field($modelYachtInquireForm, 'message')->textArea(['class' => "default white", 'row' => "4"])->label('Your message:') ?>

                <?php
                if (empty(\Yii::$app->user->id)) {

                    echo $form->field($modelYachtInquireForm, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]);
                }

                ?>
                <div class="text-center">
                    <?= Html::submitButton('Send', ['class' => "blue-btn"]) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>

<?php if (!empty($modelYachtInquireForm->message)) { ?>
    <script>
        jQuery(document).ready(function () {
            $('#inquire').modal('show');
        });
    </script>


<?php } ?>
