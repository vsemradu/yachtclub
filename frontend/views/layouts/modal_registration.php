<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$model->scenario = 'insert';
$modelInfo->scenario = 'insert';

?>
<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= \Yii::t('registration', 'CREATE AN ACCOUNT'); ?></h4>
            </div>
            <div class="modal-body">

                <a href="javascript:;" onclick="checkLoginState();" class="fb-login">
                    <i class="fa fa-facebook"></i>
                    <?= \Yii::t('registration', ' Sign Up with Facebook'); ?>
                </a>

                <div class="lined">
                    <span>
                        <?= \Yii::t('registration', ' or<br>Sign Up with Email'); ?>    
                    </span>
                </div>

                <?php
                $form = ActiveForm::begin([
                        'id' => 'modal-form-signup',
                        'action' => ['site/signup'],
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                ]);

                ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($modelInfo, 'first_name')->textInput(['class' => 'form-control', 'placeholder' => \Yii::t('registration', 'First Name*')])->label(false) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($modelInfo, 'last_name')->textInput(['class' => 'form-control', 'placeholder' => \Yii::t('registration', 'Last Name*')])->label(false) ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => \Yii::t('registration', 'Email*')])->label(false) ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'password')->passwordInput([ 'class' => 'form-control', 'placeholder' => \Yii::t('registration', 'Password*')])->label(false) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'confirm_password')->passwordInput([ 'class' => 'form-control', 'placeholder' => \Yii::t('registration', 'Confirm Password*')])->label(false) ?>
                        </div>
                    </div>
                </div>

                <div class="checkbox">

                    <?php
                    echo $form->field($model, 'termsCondition')->checkbox(['template' => "{input}".\Yii::t('registration', '<span>I agree to</span> <a href="#">Term&Conditions</a>')."{error}"])->label(false);

                    ?>

                </div>

                <button type="submit" class="login-form-btn">
                    <?= \Yii::t('registration', 'SIGN ME UP'); ?> 
                </button>

                <p class="not-user">
                    <?= \Yii::t('registration', '<span>Already have an account?</span>'); ?> <a href="#" class="js-modal-reg-button"><?= \Yii::t('registration', 'Login Here'); ?></a>
                </p>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>