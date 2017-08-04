<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="header-map"></div>
<section class="container-fluid rec-password">
    <div class="row">
        <div class="container">
            <div class="boat-block"></div>
            <h1>
                <?= \Yii::t('resetPassword', 'Password lost at sea? Let us rescue it for you.'); ?>
            </h1>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => \Yii::t('resetPassword', "Email")])->label(false) ?>
            <div class="footer-btns">

                <?= Html::submitButton(\Yii::t('resetPassword', 'SEND'), ['class' => 'blue-btn']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
