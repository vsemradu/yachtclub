<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>


<div class="header-map"></div>
<section class="container-fluid rec-password">
    <div class="row">
        <div class="container">
            <div class="boat-block"> </div>
            <h1>
                <?= \Yii::t('resetPassword', 'Password lost at sea? Let us rescue it for you.'); ?> 
            </h1>
            <p><?= \Yii::t('resetPassword', 'Please enter a new password'); ?> </p>

            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => \Yii::t('resetPassword', "Password")])->label(false) ?>
            <div class="footer-btns">
                <?= Html::submitButton(\Yii::t('resetPassword', 'SEND'), ['class' => 'blue-btn']) ?>
            </div>
            <?php ActiveForm::end(); ?>
       
    </div>
</section>
