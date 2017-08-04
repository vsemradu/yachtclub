<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" id="loginModal">
            
            <div class="modal-body">
                <a href="javascript:;" onclick="checkLoginState();" class="fb-login">
                    <i class="fa fa-facebook"></i>
                    <?= \Yii::t('login', 'Connect with Facebook'); ?>
                </a>
                <div class="lined">
                    <span>
                        <?= \Yii::t('login', 'or<br>Login with Email'); ?>

                    </span>
                </div>

                <?php
                $form = ActiveForm::begin([
                        'id' => 'model-login-form',
                        'action' => ['site/login'],
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                ]);

                ?>
                <div class="form-group">
                    <?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => \Yii::t('login', 'Email*')])->label(false) ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'password')->passwordInput([ 'class' => 'form-control', 'placeholder' => \Yii::t('login', 'Password*')])->label(false) ?>
                </div>
                <?= Html::a(\Yii::t('login', 'Forgot password ?'), ['site/request-password-reset'], ['class' => "fogot-password"]) ?>


                <button type="submit" name="login" value="true" class="login-form-btn">
                    <?= \Yii::t('login', 'LOGIN'); ?> 
                </button>

                <p class="not-user">
                    <?= \Yii::t('login', '<span>Not a member?</span>'); ?> <a href="#" class="js-modal-login-button"><?= \Yii::t('login', 'Sign Up Now!'); ?></a>
                </p>
                <?php ActiveForm::end(); ?>
            </div>
            
        </div>
    </div>
</div>