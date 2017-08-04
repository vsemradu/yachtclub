<?php
use common\models\Pin;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="col-md-12">
    <div class="row edit-location first">
        <?= $form->field($pinField, 'name')->textInput(['class' => '', 'placeholder' => \Yii::t('createPin', 'Name or Short Description*')])->label(false) ?>
    </div>
</div>


<?php
if (Yii::$app->request->isAjax) {
    echo $this->renderAjax('_form_raiting', ['pinField' => $pinField, 'form' => $form]);
} else {
    echo $this->render('_form_raiting', ['pinField' => $pinField, 'form' => $form]);
}

?>


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

