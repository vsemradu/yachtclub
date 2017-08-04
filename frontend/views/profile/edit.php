<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<!-- PROFILE page -->

<section class="container-fluid profile-page">
    <div class="row">
        <div class="container">

            <?= $this->render('header_profile'); ?>


            <div class="profile-tabs-content">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="page-preview">
                            <div class="head">
                                <?= \Yii::t('profile', 'Upload photo'); ?>
                            </div>
                            <?php
                            $form = ActiveForm::begin([
                                    'id' => 'edit-photo-form',
                                    'action' => ['profile/edit'],
                                    'options' => ['enctype' => 'multipart/form-data']
                            ]);

                            ?>
                            <div class="upload clearfix">
                                <p class="text">
                                    <?= \Yii::t('profile', 'Please upload a profile picture'); ?>
                                </p>

                                <?php if (!empty($user->userInfo->imageUrl)) { ?>


                                    <ul class="bar edit">
                                        <li>
                                            <img width="300" src="<?= $user->userInfo->imageUrl ?>" alt="photo">
                                        </li>

                                        <li class="btns">
                                            <a href="#" class="js-profile-delete"><i class="fa fa-trash-o"></i> Delete</a>
                                        </li>
                                    </ul>
                                <?php } ?>
                                <ul class="bar">
                                    <li>
                                        <?= $form->field($modelImage, 'upload_image')->fileInput()->label(false) ?>
                                    </li>
                                </ul>

                                <div class="footer-btns">
                                    <button type="submit" name="update_photo" value="true" class="blue-btn"> <?= \Yii::t('profile', 'UPLOAD'); ?></button>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="page-preview">

                            <?php
                            $form = ActiveForm::begin([
                                    'id' => 'edit-personal-information-form',
                                    'action' => ['profile/edit'],
                                    'enableClientValidation' => true,
                                    'enableAjaxValidation' => false,
                            ]);

                            ?>
                            <div class="head">
                                <?= \Yii::t('profile', 'Edit Personal Information'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="row edit-location first">
                                        <div class="col-md-12">
                                            <?= $form->field($modelInfo, 'first_name')->textInput(['class' => '', 'value' => Yii::$app->user->identity->userInfo->first_name, 'placeholder' => \Yii::t('profile', 'First Name')])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="row edit-location">
                                        <div class="col-md-12">
                                            <?= $form->field($modelInfo, 'last_name')->textInput(['class' => '', 'value' => Yii::$app->user->identity->userInfo->last_name, 'placeholder' => \Yii::t('profile', 'Last Name')])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="row edit-location">
                                        <div class="col-md-12">
                                            <?= $form->field($modelInfo, 'location')->textInput(['id' => "js-google-autocomplete", 'class' => '', 'placeholder' => \Yii::t('profile', 'Location')])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <button type="submit" name="update_information" value="true" class="blue-btn middle"> <?= \Yii::t('profile', 'SAVE'); ?></button>
                                </div>
                            </div>


                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="page-preview">
                            <div class="head">   <?= \Yii::t('profile', 'Account Security'); ?></div>

                            <div class="row">
                                <div class="col-lg-5">

                                    <?php
                                    $form = ActiveForm::begin([
                                            'id' => 'edit-email-form',
                                            'action' => ['profile/edit'],
                                            'enableClientValidation' => true,
                                            'enableAjaxValidation' => false,
                                    ]);

                                    ?>
                                    <div class="row edit-location first">
                                        <div class="col-md-12 lined">
                                            <?= $form->field($model, 'email')->textInput(['class' => ' ', 'placeholder' => \Yii::t('registration', 'appleseed@gmail.com')])->label(false) ?>
                                        </div>
                                    </div>


                                    <div class="footer-btns">
                                        <button type="submit" name="update_email" value="true" class="blue-btn"> <?= \Yii::t('profile', 'SAVE'); ?></button>

                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>

                                <div class="col-lg-6 col-lg-offset-1">
                                    <div class="row">
                                        <?php
                                        $form = ActiveForm::begin([
                                                'id' => 'edit-password-form',
                                                'action' => ['profile/edit'],
                                                'enableClientValidation' => true,
                                                'enableAjaxValidation' => false,
                                        ]);

                                        ?>
                                        <div class="col-md-7">
                                            <div class="row edit-location first">
                                                <div class="col-md-12">
                                                    <?= $form->field($model, 'old_password')->passwordInput([ 'class' => '', 'placeholder' => \Yii::t('registration', 'Old Password')])->label(false) ?>
                                                </div>
                                            </div>

                                            <div class="row edit-location">
                                                <div class="col-md-12">
                                                    <?= $form->field($model, 'password')->passwordInput([ 'class' => '', 'placeholder' => \Yii::t('registration', 'New Password')])->label(false) ?>
                                                </div>
                                            </div>

                                            <div class="row edit-location last">
                                                <div class="col-md-12">
                                                    <?= $form->field($model, 'confirm_password')->passwordInput([ 'class' => '', 'placeholder' => \Yii::t('registration', 'Confirm Password')])->label(false) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 edit-apply">
                                            <button type="submit" name="update_password" value="true" class="red-btn"><?= \Yii::t('profile', 'APPLY'); ?></button>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- END PROFILE PAGE -->