<?php
use common\models\Pin;
use common\models\PinField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="col-md-12">
    <div class="row edit-location first">
        <?= $form->field($pinField, 'name')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Name*')])->label(false) ?>
    </div>
</div>


<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'location')->textInput(['class' => '', 'id' => 'js-google-autocomplete', 'placeholder' => \Yii::t('createPin', 'Location*')])->label(false) ?>
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
                        <?= $form->field($pinField, 'reef_vreak')->checkbox(['class' => '']) ?>
                    </label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <?= $form->field($pinField, 'point_break')->checkbox(['class' => '']) ?>
                    </label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <?= $form->field($pinField, 'beach_break')->checkbox(['class' => '']) ?>
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
                <?= \Yii::t('createPin', 'Breaks'); ?> 
            </label>
        </div>

        <div class="col-sm-3">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'break')->radio(['class' => '', 'value' => PinField::SURFSPOT_BREAKS_LEFT, 'uncheck' => null])->label('Left') ?>

                </label>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'break')->radio(['class' => '', 'value' => PinField::SURFSPOT_BREAKS_BOTH, 'uncheck' => null])->label('Both') ?>
                </label>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'break')->radio(['class' => '', 'value' => PinField::SURFSPOT_BREAKS_RIGHT, 'uncheck' => null])->label('Right') ?>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row edit-location">
    <div class="col-md-9">
        <?= $form->field($pinField, 'swell_hight')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Swell hight')])->label(false) ?>
    </div>
    <div class="col-md-3">
        <div class="select">
            <?= $form->field($pinField, 'swell_hight_type')->dropDownList(\common\models\PinField::itemAlias('vessel_type'), ['class' => ''])->label(false) ?>


        </div>
    </div>
</div>


<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'wind_direction')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Wind direction')])->label(false) ?>
    </div>
</div>

<div class="col-md-12">
    <div class="row edit-location">
        <?= $form->field($pinField, 'swell_direction')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Swell direction')])->label(false) ?>
    </div>
</div>
<?php $this->registerJs("initializeAutoCompleate();", \yii\web\View::POS_END); ?>

