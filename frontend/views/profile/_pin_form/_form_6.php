<?php
use common\models\Pin;
use common\models\PinField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="col-md-12">
    <div class="row edit-location first">
        <?= $form->field($pinField, 'name')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Name of Marina or Spot*')])->label(false) ?>
    </div>
</div>



<?php
if (Yii::$app->request->isAjax) {
    echo $this->renderAjax('_form_raiting', ['pinField' => $pinField, 'form' => $form]);
} else {
    echo $this->render('_form_raiting', ['pinField' => $pinField, 'form' => $form]);
}

?>

<div class="col-md-12 radio-group lined no-success">
    <div class="row">

        <div class="col-lg-4">
            <label class="title">
<?= \Yii::t('createPin', 'Fuel Quality Rating'); ?>
            </label>
        </div>

        <div class="col-lg-3">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'quality_rating')->radio(['class' => '', 'value' => PinField::FUEL_FUEL_GREAT, 'uncheck' => null])->label('<img src="../img/green_ico.png" alt="" class="radio-icons"> Great') ?>
                   
                </label>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'quality_rating')->radio(['class' => '', 'value' => PinField::FUEL_FUEL_GOOD, 'uncheck' => null])->label('<img src="../img/yellow_ico.png" alt="" class="radio-icons"> Good') ?>
                    
                </label>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'quality_rating')->radio(['class' => '', 'value' => PinField::FUEL_FUEL_BAD])->label('<img src="../img/red_ico.png" alt="" class="radio-icons"> Bad') ?>
                    
                </label>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 lined-radio no-lined no-success">
    <div class="row">
        <div class="row">
        <div class="col-sm-4">
            <div class="checkbox">
                <label>

                    <?= $form->field($pinField, 'ice')->checkbox(['class' => '']) ?>
                </label>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="checkbox">
                <label>
                    <?= $form->field($pinField, 'provisions')->checkbox(['class' => '']) ?>
                </label>
            </div>
        </div>
        </div>
    </div>
</div>



<div class="col-md-12">
    <div class="row edit-location">
<?= $form->field($pinField, 'warnings')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Warnings')])->label(false) ?>
    </div>
</div>


<div class="row edit-location">
    <div class="col-md-9">

<?= $form->field($pinField, 'fuel_price')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Fuel Price')])->label(false) ?>
    </div>
    <div class="col-md-3">
        <div class="select">

<?= $form->field($pinField, 'fuel_price_type')->dropDownList(\common\models\PinField::itemAlias('fuel_watter_type'), ['class' => ''])->label(false) ?>
        </div>
    </div>
</div>

<div class="row edit-location">
    <div class="col-md-9">
<?= $form->field($pinField, 'water_price')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Water Price')])->label(false) ?>
    </div>
    <div class="col-md-3">
        <div class="select">


<?= $form->field($pinField, 'water_price_type')->dropDownList(\common\models\PinField::itemAlias('fuel_watter_type'), ['class' => ''])->label(false) ?>
        </div>
    </div>
</div>
