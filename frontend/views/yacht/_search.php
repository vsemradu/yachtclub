<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YachtSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yacht-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'subtype') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'yacht_build') ?>

    <?php // echo $form->field($model, 'home_port') ?>

    <?php // echo $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'beam') ?>

    <?php // echo $form->field($model, 'draft') ?>

    <?php // echo $form->field($model, 'air_draft') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'summary') ?>

    <?php // echo $form->field($model, 'background_image_id') ?>

    <?php // echo $form->field($model, 'enable_blog') ?>

    <?php // echo $form->field($model, 'charter_company') ?>

    <?php // echo $form->field($model, 'contact_info') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yacht', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('yacht', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
