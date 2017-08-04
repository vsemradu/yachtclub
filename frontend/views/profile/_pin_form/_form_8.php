<?php
use common\models\Pin;
use common\models\PinField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\rating\StarRating;

?>

<div class="col-md-12">
    <div class="row edit-location first">
        <?= $form->field($pinField, 'name')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Name of Marina or Spot*')])->label(false) ?>
    </div>
</div>

<?php
  if (Yii::$app->request->isAjax) {
     echo $this->renderAjax('_form_raiting', ['pinField' => $pinField, 'form' => $form]);
  }else{
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
                    <?= $form->field($pinField, 'beach_break')->checkbox(['class' => ''])?>
                </label>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="col-md-12 radio-group no-margin no-success">
    <div class="row">
        <div class="col-sm-6">
            <label class="title">
                <?= \Yii::t('createPin', 'How severe?'); ?>
            </label>
        </div>
        <div class="col-sm-2">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'how_severe')->radio(['class' => '', 'value' => PinField::WARNING_HOW_SEVERE_YELLOW, 'uncheck'=>null])->label('<i class="ion-alert-circled yellow"></i>') ?>
                    
                </label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'how_severe')->radio(['class' => '', 'value' => PinField::WARNING_HOW_SEVERE_ORANGE, 'uncheck'=>null])->label('<i class="ion-alert-circled orange"></i>') ?>
                    
                </label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="radio">
                <label>
                    <?= $form->field($pinField, 'how_severe')->radio(['class' => '', 'value' => PinField::WARNING_HOW_SEVERE_RED, 'uncheck'=>null])->label('<i class="ion-alert-circled red"></i>') ?>
                    
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row edit-location offset-bottom-default">
    <div class="col-md-12">
        <?= $form->field($pinField, 'warnings')->textArea([ 'rows' => "4", 'class' => 'form-control', 'placeholder' => \Yii::t('createPin', 'Warnings')])->label(false) ?>
    </div>
</div>


