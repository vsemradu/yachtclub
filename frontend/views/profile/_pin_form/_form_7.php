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
            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <?= $form->field($pinField, 'pestaurant')->checkbox(['class' => '']) ?>
                    </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <?= $form->field($pinField, 'fuel')->checkbox(['class' => '']) ?>
                    </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <?= $form->field($pinField, 'port_of_entry')->checkbox(['class' => '']) ?>
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

<div class="col-md-12 radio-group with-title no-success">
    <div class="row">

        <p class="title">
            <?= \Yii::t('createPin', 'Electric Services (US)'); ?>

        </p>
        <?php foreach (PinField::itemAlias('electric_services') as $key => $value) { ?>
            <div class="col-sm-4">
                <div class="radio">
                    <label>
                        <?= $form->field($pinField, 'electric_services[]')->checkbox(['id'=>'electric_services'.$key,'class' => '', 'uncheck' => null, 'value' => $key])->label($value) ?>
                    </label>
                </div>
            </div>

        <?php } ?>
        
    </div>
</div>


<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'electricity_price')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Electricity Price')])->label(false) ?>
    </div>
</div>


<div class="row edit-location">
    <div class="col-md-9">
        <?= $form->field($pinField, 'dockage_price')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Dockage Price')])->label(false) ?>
    </div>
    <div class="col-md-3">
        <div class="select">
            <?= $form->field($pinField, 'dockage_price_type')->dropDownList(\common\models\PinField::itemAlias('vessel_type'), ['class' => ''])->label(false) ?>
        </div>
    </div>
</div>

<div class="row edit-location">
    <div class="col-md-9">
        <?= $form->field($pinField, 'water_price')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Water price')])->label(false) ?>
    </div>
    <div class="col-md-3">
        <div class="select">
            <?= $form->field($pinField, 'water_price_type')->dropDownList(\common\models\PinField::itemAlias('fuel_watter_type'), ['class' => ''])->label(false) ?>
        </div>
    </div>
</div>
