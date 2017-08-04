<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\UserPin;
use common\models\Yacht;
use common\models\Reviews;
use kartik\rating\StarRating;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;

?>




<div class="container add-reviews" >

    <?php
    $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'validateOnSubmit' => false,
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,
    ]);

    ?>

    <div class="form-group">
        <?= $form->field($reviews, 'title')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg', 'placeholder' => 'Title'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= $form->field($reviews, 'text')->textarea(['rows' => "5", 'class' => 'form-control input-lg', 'placeholder' => 'Review'])->label(false) ?>
    </div>





    <div class="rating-choose">
        <div class="label-rating">
            <?= \Yii::t('reviews', '  Choose a Rating <span>*</span>'); ?>
        </div>


        <?php
        echo StarRating::widget(['model' => $reviews, 'attribute' => 'rating',
            'pluginOptions' => [
                'disabled' => false,
                'showClear' => false,
                'step' => 1,
                'showCaption' => false,
                'glyphicon' => false,
                'symbol' => '',
                'id' => uniqid(),
            ],
        ]);

        ?>
        <div class="form-group field-reviews-text required has-error">
            <p class="help-block help-block-error"> <?= Html::error($reviews, 'rating') ?></p>
        </div>
    </div>

    <?= $form->field($reviews, 'approved')->dropDownList([Reviews::APPROVED_FALSE => 'False', Reviews::APPROVED_TRUE => 'True']) ?>

    <div class="form-group">
        <?= Html::submitButton($reviews->isNewRecord ? Yii::t('reviews', 'Submit') : Yii::t('reviews', 'Submit'), ['class' => $reviews->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>