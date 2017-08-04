<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Busines;
use yii\widgets\Pjax;
use kartik\file\FileInput;
use kartik\typeahead\TypeaheadBasic;
use kartik\rating\StarRating;
use vova07\fileapi\Widget as FileAPI;

?>
<!-- rec page -->
<div class="header-map large"></div>
<?php Pjax::begin(); ?>
<?php
$form = ActiveForm::begin([
        'id' => 'pin-form',
        'options' => ['enctype' => 'multipart/form-data']
    ]);

?>

<section class="container create-pin">
    <p class="wave-title">
        <?= \Yii::t('business', 'Update Profile for a Business'); ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="page-preview blue height">
                <div class="head"><?= \Yii::t('business', 'General info'); ?></div>

                <?php if ($business->owner == Busines::OWN_FALSE) { ?>
                    <div class="col-md-12">
                        <div class="row edit-location first">

                            <?=
                            $form->field($business, 'rating')->widget(StarRating::classname(), [
                                'pluginOptions' => [
                                    'disabled' => false,
                                    'showClear' => false,
                                    'step' => 1,
                                    'showCaption' => false,
                                    'glyphicon' => false,
                                    'symbol' => '',
                                ]
                            ])->label(false);

                            ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="col-md-12">
                    <div class="row edit-location first">

                        <?= $form->field($business, 'business_name')->textInput(['class' => '', 'placeholder' => \Yii::t('business', 'Business Name *')])->label(false) ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row edit-location">
                        <?= $form->field($business, 'address')->textInput(['class' => '', 'id' => 'js-google-autocomplete', 'placeholder' => \Yii::t('business', 'Address')])->label(false) ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row edit-location">
                        <?= $form->field($business, 'phone')->textInput(['class' => '', 'placeholder' => \Yii::t('business', 'Phone')])->label(false) ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row edit-location">
                        <?= $form->field($business, 'website')->textInput(['class' => '', 'placeholder' => \Yii::t('business', 'Website')])->label(false) ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row edit-location">
                        <?= $form->field($business, 'summary')->textArea(['rows' => "4", 'class' => 'default', 'placeholder' => \Yii::t('business', 'Summary')])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="page-preview">
                <div class="head">
                    <?= \Yii::t('business', 'Upload background image'); ?>
                </div>

                <div class="upload clearfix">

                    <div class="photos">
                        <?php if (!empty($business->businessImageFon)) { ?>
                            <div data-id="<?= $business->image_id ?>" class="item js-delete-fon-photo">
                                <img src="<?= $business->businessImageFon->imageUrl ?>" width="200" alt="">
                                <a href="#" class="data-photo-overlay">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        <?php } ?>

                    </div>
                    <?php
                    echo $form->field($image, 'name')->widget(
                        FileAPI::className(), [
                        'settings' => [
                            'url' => ['/yacht/fileapi-upload'],
                            'onSelect' => 'function (imageFile){alert();}',
                        ],
                        'crop' => true,
                        ]
                    );

                    ?>
                </div>
            </div>
            <div class="page-preview">



                <div class="head">
                    <?= \Yii::t('business', 'Upload photos'); ?>
                </div>

                <div class="upload clearfix">
                    <p class="text">
                        <?= \Yii::t('business', ' Upload any photos that will help people know what this business is all about'); ?>

                    </p>
                    <div class="photos">
                        <?php foreach ($business->businessImages as $businessImages) { ?>
                            <div data-id="<?= $businessImages->id ?>" class="item js-delete-photo">
                                <img src="<?= $businessImages->image->imageUrl ?>" width="200" alt="">
                            </div>
                        <?php } ?>
                    </div>
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
                </div>
            </div>

            <div class="page-preview">
                <div class="head">
                    <?= \Yii::t('business', 'Related Pin'); ?>
                </div>

                <div class="upload clearfix">
                    <p class="text">
                        <?= \Yii::t('business', ' If there is a pin related to your business, please indicate it here'); ?>

                    </p>

                    <div class="col-md-12">
                        <div class="row edit-location">
                            <?php
                            if (!empty($dataPins)) {
                                echo $form->field($business, 'pin_id')->widget(TypeaheadBasic::classname(), [
                                    'data' => $dataPins,
                                    'options' => ['placeholder' => 'Enter Pin Name', 'value' => !empty($business->businessPin->pin->pinField->name) ? $business->businessPin->pin->pinField->name : '',],
                                    'pluginOptions' => ['highlight' => true],
                                ])->label(false);
                            } else {

                                echo $form->field($business, 'pin_id')->textInput(['class' => '', 'placeholder' => \Yii::t('business', 'Enter Pin Name'), 'value' => !empty($business->businessPin->pin->pinField->name) ? $business->businessPin->pin->pinField->name : ''])->label(false);
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo $this->render('//busines/_block_happy_hour_form', [
        'business' => $business,
        'happyHours' => $happyHours,
        'remove' => true,
    ]);

    ?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <button type="submit" name="save" value="save" class="blue-btn middle-second"> <?= \Yii::t('business', 'Update'); ?></button>
        </div>
    </div>

</section>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>


<script>
    $(function () {
        $('.js-add-happy-hours').click(function (event) {
            $.post("/busines/ajax-happy-hours", {form: '<?= json_encode($form) ?>'})
                    .done(function (data) {
                        $('.js-happy-hours-form').append(data);
                    });
            event.preventDefault();
        });


        $('body').on('click', '.js-remove', function (event) {

            if (confirm("Do you want delete this Special?")) {
                var happy_hour_id = $(this).data('id');
                var business_id = $(this).data('business_id');
                if (business_id != '' && happy_hour_id != '') {
                    $.get("/busines/ajax-delete-happy-hours", {business_id: business_id, happy_hour_id: happy_hour_id});
                }

                $(this).parents('.js-happy-hours-block').remove();
            }



            event.preventDefault();
        });

        $('.js-delete-fon-photo').click(function () {

            if (confirm("Are you sure to delete?")) {
                var photo_id = $(this).data('id');
                var block = this;
                $.get("/busines/ajax-delete-fon-photo", {business_id: <?= $business->id ?>, photo_id: photo_id})
                        .done(function (data) {
                            $(block).remove();

                        });
            }

        });


        $('.js-delete-photo').click(function () {

            if (confirm("Are you sure to delete?")) {
                var business_photo_id = $(this).data('id');
                var block = this;
                $.get("/busines/ajax-delete-photo", {business_id: <?= $business->id ?>, business_photo_id: business_photo_id})
                        .done(function (data) {
                            $(block).remove();

                        });
            }

        });
    });


</script>



<!-- END rec PAGE -->