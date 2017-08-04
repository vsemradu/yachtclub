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

<?= Html::hiddenInput('type_text', $type_text) ?>
<?= Html::hiddenInput('owner', $owner) ?>
<?= Html::hiddenInput('type_id', $type_id) ?>
<?= Html::hiddenInput('private', $private) ?>
<section class="container create-pin">
    <p class="wave-title">
        <?= \Yii::t('business', 'Create Profile for a Business'); ?>
    </p>


    <div class="row bordered-qw">
        <div class="col-md-6 bordered-qw-item first">
            <div class="bordered-qw-wrap">
                <h2 class="h2-title">
                    <?= \Yii::t('business', 'What type of Business is this?'); ?>
                </h2>
                <div class="radio">
                    <label>

                        <?php if ($type_id == Busines::TYPE_OTHER) { ?>
                            <input type="radio" name="optionsRadios" checked="">
                            <?= $type_text ?>
                        <?php } else { ?>
                            <input type="radio" name="optionsRadios" checked="">
                            <img src="../img/create_icons/<?= $type_id ?>.png" alt="">
                            <?= Busines::itemAlias('type_title', $type_id) ?>
                        <?php } ?>


                        <a href="/busines/type?type_id=<?= $type_id ?>&owner=<?= $owner ?>&type_text=<?= $type_text ?>" class="edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-6 bordered-qw-item">
            <div class="bordered-qw-wrap">
                <h2 class="h2-title">
                    <?= \Yii::t('business', 'Do you own or manage this business?'); ?>
                </h2>
                <div class="no-qw">
                    <label>

                        <?php if ($owner == Busines::OWN_TRUE) { ?>
                            <?= \Yii::t('business', 'YES'); ?>
                        <?php } else { ?>
                            <?= \Yii::t('business', 'NO'); ?>
                        <?php } ?>
                        <a href="/busines/type?type_id=<?= $type_id ?>&owner=<?= $owner ?>&type_text=<?= $type_text ?>" class="edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <?php if ($owner != Busines::OWN_TRUE) { ?>
        <div class="red-title">Be the first to rate!</div>
    <?php } ?>


    <div class="row">
        <div class="col-md-6">
            <div class="page-preview blue height">

                <div class="head">
                    <?php if ($owner != Busines::OWN_TRUE) { ?>
                        <?= \Yii::t('business', 'Tell us about your experience'); ?>
                    <?php }else{ ?>
                        <?= \Yii::t('business', 'General info'); ?>
                    <?php } ?>
                </div>

                <?php if ($owner == Busines::OWN_FALSE) { ?>
                    <div class="col-md-12">
                        <div class="row edit-location first with-center-raring">

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
            <button type="submit" name="save" value="save" class="blue-btn middle-second"> <?= \Yii::t('business', 'Save'); ?></button>
        </div>
    </div>
</section>


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
    });
</script>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>



<!-- END rec PAGE -->