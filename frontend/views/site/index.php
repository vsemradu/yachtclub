<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Yacht;
use yii\widgets\ActiveForm;

?>



<script>
    var pins = <?= !empty($pins) ? $pins : '""' ?>;
    var localInfo = <?= !empty($localInfos) ? $localInfos : '""' ?>;
    var apiGoogleKey = '<?= Yii::$app->params['apiGoogleKey'] ?>';
</script>
<script src="/js/google_map.js"></script>




<section class="home-page-map">

    <div class="home-page-map-overlay">
        <p>
            <?= \Yii::t('home', 'Everything you need to know<br>about everywhere you need to float'); ?>
        </p>
    </div>
    <div style="width: 100%; height: 100%; position: absolute;" class="map-canvas off" id="js-map-canvas"></div>



    <button class="go-down-btn" id="go-down-home">
        <i class="fa fa-chevron-down"></i>
    </button>

</section>


<?php if (!Yii::$app->user->isGuest) { ?>
    <section class="container login-landing-btns">
        <div class="row">
            <div class="col-sm-3 col-sm-offset-3">
                <a href="javascript:;" onclick="javascript:$('#businessModal').modal('show');" class="red-btn"><?= \Yii::t('home', 'CREATE PAGE'); ?></a>
            </div>
            <div class="col-sm-3">
                <a href="#" id="js-drop-pin" class="blue-btn"><?= \Yii::t('home', 'DROP PIN'); ?></a>
            </div>
        </div>
    </section>
<?php } ?>

<section class="container feauture-week">
    <p class="wave-title">
        <?= \Yii::t('home', 'FEATURE OF THE WEEK'); ?>
    </p>

    <div class="owl-carousel">

        <?php foreach ($blogsWeek as $blogWeek) { ?>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?= $blogWeek->imageUrl; ?>" alt="">
                </div>
                <div class="col-md-5">
                    <?= $blogWeek->description ?>
                </div>
            </div>
        <?php } ?>

    </div>
</section>

<section class="weather">
    <p class="wave-title">
        <?= \Yii::t('home', 'WEATHER'); ?>
    </p>

    <div class="js-weather-search weather-input-block">
        <input type="text" value="USA" id="js-google-autocomplete">
        <button class="js-send-weather"><?= \Yii::t('home', 'Search'); ?></button>
    </div>



    <?= $this->render('//layouts/container_weather', ['data_weather' => $data_weather]) ?>
</section>

<section class="container blog">
    <p class="wave-title">
        <?= \Yii::t('home', 'BLOG'); ?> 
    </p>

    <div class="row">
        <div class="col-md-6 left-col">

            <?php \yii\widgets\Pjax::begin(['id' => 'blog-currents']); ?>
            <?=
            yii\widgets\ListView::widget([
                'dataProvider' => $dataProviderCurrentBlogs,
                'itemView' => '_blog_current_view',
                'layout' => "{items}\n{pager}",
            ]);

            ?>
            <?php \yii\widgets\Pjax::end(); ?>




        </div>
        <div class="col-md-6 right-col">


            <?php \yii\widgets\Pjax::begin(['id' => 'blogs']); ?>
            <?=
            yii\widgets\ListView::widget([
                'dataProvider' => $dataProviderBlogs,
                'itemView' => '_blog_view',
                'layout' => "{items}\n{pager}",
            ]);

            ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</section>

<div class="modal fade" id="businessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= \Yii::t('home', 'Create Page'); ?></h4>
            </div>
            <div class="modal-body">


                <div class="text">
                    <p>
                        <?= \Yii::t('home', 'Select what type of page you want to create'); ?>
                    </p>
                </div>
                <ul class="pins-list">
                    <li class="js-yacht"><span class="ico"><img src="../img/create_icons/popicon_1.png" alt=""> </span><?= \Yii::t('home', 'Create Profile for a Vessel'); ?></li>
                    <li><a href="/busines/type"><span class="ico"><img src="../img/create_icons/popicon_2.png" alt=""> </span><?= \Yii::t('home', 'Create Profile for a Business'); ?></a></li>
                </ul>




                <div class="footer-btn center-btns">
                    <a href="javascript:;" onclick="javascript:$('#businessModal').modal('hide');" class="blue-btn"><?= \Yii::t('home', 'Cancel'); ?></a>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="yachtModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= \Yii::t('home', 'Create Yacht Page'); ?></h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['action' => '/yacht/create']); ?>
                <div class="js-yacht-select-type-block">
                    <p class="modal-p">
                        <?= \Yii::t('home', 'Is this a'); ?>
                    </p>
                    <ul class="pins-list">
                        <li daya-id="<?= Yacht::TYPE_CHARTER ?>" class="js-yacht-charter"><span class="ico "><img src="../img/create_icons/cahrter_icon.png" alt=""> </span><?= \Yii::t('home', 'Charter Vessel'); ?></li>
                        <li daya-id="<?= Yacht::TYPE_PRIVATE ?>" class="js-yacht-private"><span class="ico "><img src="../img/create_icons/private_icon.png" alt=""> </span><?= \Yii::t('home', 'Private Vessel'); ?></li>
                    </ul>

                    <ul class="js-yacht-type-charter ul-checkboxes" style="display: none;">
                        <li><span class="js-yacht-type"><?= Html::radio('subtype_id', false, ['class' => '', 'value' => Yacht::TYPE_CHARTER_CREWED, 'uncheck' => null]) ?></span> <?= \Yii::t('home', 'Crewed Boat'); ?></li>
                        <li><span class="js-yacht-type"><?= Html::radio('subtype_id', false, ['class' => '', 'value' => Yacht::TYPE_CHARTER_BARE, 'uncheck' => null]) ?></span> <?= \Yii::t('home', 'Bare Boat'); ?></li>
                    </ul>

                    <ul class="js-yacht-type-private ul-checkboxes"  style="display: none;">
                        <li><span class="js-yacht-type"><?= Html::radio('subtype_id', false, ['class' => '', 'value' => Yacht::TYPE_PRIVATE_CREWED, 'uncheck' => null]) ?></span> <?= \Yii::t('home', 'Crewed Boat'); ?></li>
                        <li><span class="js-yacht-type"><?= Html::radio('subtype_id', false, ['class' => '', 'value' => Yacht::TYPE_PRIVATE_OWNER, 'uncheck' => null]) ?></span> <?= \Yii::t('home', 'Owner Operated Boat'); ?></li>
                    </ul>
                </div>


                <div class="footer-btn js-page-create center-btns" style="display: none;">
                    <button  type="submit" class="blue-btn"> <?= \Yii::t('home', 'Create'); ?></button>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        $('.js-yacht').click(function (event) {
            $('#businessModal').modal('hide');
            $('#yachtModal').modal('show');

        });
        $('.js-yacht-charter').click(function (event) {
            $('.js-yacht-type-private').hide(300);
            $('.js-yacht-type-charter').show(300);

        });
        $('.js-yacht-private').click(function (event) {
            $('.js-yacht-type-charter').hide(300);
            $('.js-yacht-type-private').show(300);

        });
        $('.js-yacht-type').click(function (event) {
            $('.js-page-create').show(300);
        });
    });


</script>
