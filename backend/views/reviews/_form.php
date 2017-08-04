<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reviews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'business_id')->textInput() ?>

    <?= $form->field($model, 'yacht_id')->textInput() ?>

    <?= $form->field($model, 'pin_id')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'kind_trip')->textInput() ?>

    <?= $form->field($model, 'weather')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sea_swell')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wind_direction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_draft')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_lenght')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_beam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_air_draft')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_sail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rating_crew')->textInput() ?>

    <?= $form->field($model, 'rating_food')->textInput() ?>

    <?= $form->field($model, 'rating_cleanliness')->textInput() ?>

    <?= $form->field($model, 'rating_enjoyability')->textInput() ?>

    <?= $form->field($model, 'rating_maintenance')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('reviews', 'Create') : Yii::t('reviews', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
