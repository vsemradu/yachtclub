<?php
use common\models\Pin;
use common\models\PinField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="col-md-12">
    <div class="row edit-location first">
        <?= $form->field($pinField, 'name')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Name or Spot*')])->label(false) ?>
    </div>
</div>


<div class="row edit-location">
    <div class="col-md-9">
        <?= $form->field($pinField, 'max_depth')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Max Depth*')])->label(false) ?>
    </div>
    <div class="col-md-3">
        <div class="select">
            <?= $form->field($pinField, 'max_depth_type')->dropDownList(\common\models\PinField::itemAlias('vessel_type'), ['class' => ''])->label(false) ?>


        </div>
    </div>
</div>



<?php
if (Yii::$app->request->isAjax) {
    echo $this->renderAjax('_form_raiting', ['pinField' => $pinField, 'form' => $form]);
} else {
    echo $this->render('_form_raiting', ['pinField' => $pinField, 'form' => $form]);
}

?>

<div class="col-md-12 lined-radio no-success">
    <div class="row">
        <div class="row">
            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <?= $form->field($pinField, 'novice')->checkbox(['class' => '']) ?>
                    </label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <?= $form->field($pinField, 'intermidiate')->checkbox(['class' => '']) ?>
                    </label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <?= $form->field($pinField, 'expert')->checkbox(['class' => '']) ?>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 radio-group no-success">
    <div class="row">

        <div class="col-sm-3">
            <label class="title">
                <?= \Yii::t('createPin', 'Visibility'); ?> 
            </label>
        </div>

        <div class="col-sm-3">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'visibility')->radio(['class' => '', 'value' => PinField::DIVESITE_VISIBILITY_MURKY, 'uncheck' => null])->label('Murky') ?>
                </label>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'visibility')->radio(['class' => '', 'value' => PinField::DIVESITE_VISIBILITY_MODERATE, 'uncheck' => null])->label('Moderate') ?>
                </label>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'visibility')->radio(['class' => '', 'value' => PinField::DIVESITE_VISIBILITY_CRYSTAL, 'uncheck' => null])->label('Crystal') ?>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'dive_operator_name')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Dive Operator Name')])->label(false) ?>
    </div>
</div>

<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'dive_operator_address')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Dive Operator Address')])->label(false) ?>
    </div>
</div>

<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'warnings')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Warnings')])->label(false) ?>
    </div>
</div>

<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'sea_swell')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Sea Swell')])->label(false) ?>
    </div>
</div>

<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'wind_direction')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Wind Direction')])->label(false) ?>
    </div>
</div>

