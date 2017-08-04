<?php
use common\models\Pin;
use common\models\PinField;
use common\models\UserPin;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\rating\StarRating;
use kartik\file\FileInput;

?>
<div class="page-preview">
    <div class="head">
        <?= \Yii::t('createPin', ' Upload photo'); ?>
    </div>
    <div class="upload clearfix no-success">
        <p class="text">
            <?= UserPin::itemAlias('photo_text', $pinField->type_id) ?>
        </p>
        <?=
        $form->field($image, 'upload_image[]')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'showRemove' => false,
                'showUpload' => false,
            ],
        ]);

        ?>
    </div>
</div>