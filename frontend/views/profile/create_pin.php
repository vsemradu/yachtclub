<?php
use common\models\UserPin;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

$yachts = \yii\helpers\ArrayHelper::map(\common\models\Yacht::findAll(['user_id' => Yii::$app->user->id, 'share' => \common\models\Yacht::SHARE_TRUE]), 'id', 'name');

?>

<div class="header-map large"></div>



<?php Pjax::begin(['id' => 'type']); ?>
<section class="container create-pin">
    <h2 class="h2-title">
        <?= \Yii::t('createPin', 'What kind of Pin is this?'); ?>  
    </h2>



    <ul id="js-pins-type" class="pins-list">
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_ANCHORAGES . '"><span class="ico">' . Html::img('../img/pin_icons/1.png') . ' </span> ' . \Yii::t('createPin', 'Anchorage') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_ANCHORAGES], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_MOORINGS . '"><span class="ico">' . Html::img('../img/pin_icons/2.png') . ' </span> ' . \Yii::t('createPin', 'Moorings') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_MOORINGS], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_DIVESITE . '"><span class="ico">' . Html::img('../img/pin_icons/3.png') . ' </span> ' . \Yii::t('createPin', 'Dive Site') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_DIVESITE], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_SNORKELSPOT . '"><span class="ico">' . Html::img('../img/pin_icons/4.png') . ' </span> ' . \Yii::t('createPin', 'Snorkel Spot') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_SNORKELSPOT], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_SURFSPOT . '"><span class="ico">' . Html::img('../img/pin_icons/5.png') . ' </span> ' . \Yii::t('createPin', 'Surf Spot') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_SURFSPOT], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_FUEL . '"><span class="ico">' . Html::img('../img/pin_icons/6.png') . ' </span> ' . \Yii::t('createPin', 'Fuel') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_FUEL], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_MARINA . '"><span class="ico">' . Html::img('../img/pin_icons/7.png') . ' </span> ' . \Yii::t('createPin', 'Marina') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_MARINA], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_WARNING . '"><span class="ico">' . Html::img('../img/pin_icons/8.png') . ' </span> ' . \Yii::t('createPin', 'Warning') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_WARNING], ['data-pjax' => '#js-form']) ?>
        <?= Html::a('  <li class="js-type-pin" id="js-type-' . UserPin::TYPE_OTHER . '"><span class="ico">' . Html::img('../img/pin_icons/9.png') . ' </span> ' . \Yii::t('createPin', 'Other') . '</li>', ['create-pin', 'type_id' => UserPin::TYPE_OTHER], ['data-pjax' => '#js-form']) ?>
    </ul>
</section>

<?php if (!empty($pinField->type_id)) { ?>
    <div id="js-form">

        <?php
        $form = ActiveForm::begin([
                'id' => 'pin-form',
                'options' => ['enctype' => 'multipart/form-data']
        ]);

        ?>

        <h2 class="h2-title lined js-title">
            <?= UserPin::itemAlias('type_name', $pinField->type_id) ?>
        </h2>


        <section class="container create-pin">
            <div class="row">
                <div class="col-lg-7">
                    <div class="page-preview blue">
                        <div class="head"></div>
                        <?php
                        if (Yii::$app->request->isAjax) {
                            echo $this->renderAjax('_pin_form/_form_' . $pinField->type_id, ['pinField' => $pinField, 'form' => $form]);
                        } else {
                            echo $this->render('_pin_form/_form_' . $pinField->type_id, ['pinField' => $pinField, 'form' => $form]);
                        }

                        ?>
                    </div>
                </div>


                <div class="col-lg-5">

                    <?php
                    if (Yii::$app->request->isAjax) {
                        echo $this->renderAjax('_pin_form/_form_photo', ['pinField' => $pinField, 'form' => $form, 'image' => $image]);
                    } else {
                        echo $this->render('_pin_form/_form_photo', ['pinField' => $pinField, 'form' => $form, 'image' => $image]);
                    }

                    ?>

                    <div class="page-preview">
                        <div class="head">
                            <?= \Yii::t('createPin', 'Comments & Tips'); ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($pin, 'description')->textArea(['class' => 'form-control', 'rows' => "4"])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid blue-block-btns">
            <div class="row">
                <div class="container">
                    <p class="title">
                        <?= \Yii::t('createPin', 'Include Vessel Information '); ?>
                    </p>

                    <div class="row">
                        <div class="col-md-2 col-md-offset-4 js-vessel-yes">
                            <a href="#" class="red-btn">
                                <?= \Yii::t('createPin', 'YES'); ?>
                            </a>
                        </div>
                        <div class="col-md-2 js-vessel-no">
                            <a href="#" class="blue-btn">
                                <?= \Yii::t('createPin', 'NO'); ?>
                            </a>
                        </div>
                    </div>

                    <div class="row js-vessel-block" style="display: none;">              
                        <br>
                        <?php if (!empty($yachts)) { ?>
                            <div class="label-rating ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="select-block default">
                                            <div class="form-group">
                                                <?= \Yii::t('reviews', 'Select yacht:'); ?> <?= Html::activeDropDownList($pinVessel, 'yacht_id', $yachts, ['prompt' => '', 'class' => 'js-yacht-select form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $form->field($pinVessel, 'vessel_name')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_name', 'placeholder' => 'Name'])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $form->field($pinVessel, 'vessel_draft')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_draft', 'placeholder' => 'Draft'])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $form->field($pinVessel, 'vessel_lenght')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_lenght', 'placeholder' => 'Lenght'])->label(false) ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $form->field($pinVessel, 'vessel_beam')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_beam', 'placeholder' => 'Beam'])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $form->field($pinVessel, 'vessel_air_draft')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_air_draft', 'placeholder' => 'Air Draft'])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $form->field($pinVessel, 'vessel_sail')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_sail', 'placeholder' => 'Sail/Power'])->label(false) ?>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" name="save" value="true" class="blue-btn middle-second"> <?= \Yii::t('createPin', 'Save'); ?></button>
                </div>
            </div>
        </section>

        <?php ActiveForm::end(); ?>
        <script>
            $(function () {
                $.scrollTo('.js-title', 500);
                $('.js-type-pin').removeClass("active");
                $('#js-type-<?= $pinField->type_id ?>').addClass('active');
            });


        </script>
    </div>
<?php } ?>
<?php Pjax::end(); ?>

