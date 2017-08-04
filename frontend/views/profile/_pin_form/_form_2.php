<?php
use common\models\Pin;
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

        <p> <?= \Yii::t('createPin', 'Are any of these resources within a short tender ride?'); ?></p>
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


<div class="row edit-location">
    <div class="col-md-9">
<?= $form->field($pinField, 'vessel_lenght')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Max. Vessel Length')])->label(false) ?>
    </div>
    <div class="col-md-3">
        <div class="select">
<?= $form->field($pinField, 'vessel_lenght_type')->dropDownList(\common\models\PinField::itemAlias('vessel_type'), ['class' => ''])->label(false) ?>


        </div>
    </div>
</div>

<div class="row edit-location">
    <div class="col-md-9">
<?= $form->field($pinField, 'vessel_draft')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Max. Vessel Draft')])->label(false) ?>
    </div>
    <div class="col-md-3">
        <div class="select">
<?= $form->field($pinField, 'vessel_draft_type')->dropDownList(\common\models\PinField::itemAlias('vessel_type'), ['class' => ''])->label(false) ?>
        </div>
    </div>
</div>