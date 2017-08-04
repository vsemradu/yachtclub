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



<div class="container add-reviews">


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
    <div class="row">
        <div class="col-md-12">
            <div class="label-rating">
                <?= \Yii::t('reviews', ' What kind of trip was this?<span>*</span>'); ?>
            </div>
            <div class="radio">
                <label>

                    <?= Html::activeRadio($reviews, 'kind_trip', ['class' => '', 'value' => Reviews::KIND_GROUP, 'uncheck' => null, 'label' => false]) ?>
                    <?= \Yii::t('reviews', 'Group'); ?>
                </label>
            </div>

            <div class="radio">
                <label>
                    <?= Html::activeRadio($reviews, 'kind_trip', ['class' => '', 'value' => Reviews::KIND_FAMILY, 'uncheck' => null, 'label' => false]) ?>
                    <?= \Yii::t('reviews', 'Family'); ?>
                </label>
            </div>

            <div class="radio">
                <label>
                    <?= Html::activeRadio($reviews, 'kind_trip', ['class' => '', 'value' => Reviews::KIND_COUPLE, 'uncheck' => null, 'label' => false]) ?>
                    <?= \Yii::t('reviews', 'Couple'); ?>
                </label>
            </div>
            <div class="form-group field-reviews-text required has-error">
                <p class="help-block help-block-error"><?= Html::error($reviews, 'kind_trip') ?></p>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'weather')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg', 'placeholder' => 'Weather'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'sea_swell')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg', 'placeholder' => 'Sea Swell'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'wind_direction')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg', 'placeholder' => 'Wind Direction'])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="label-rating">
        <?= \Yii::t('reviews', 'Vessel Information'); ?>
    </div>



    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'vessel_name')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_name', 'placeholder' => 'Name'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'vessel_draft')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_draft', 'placeholder' => 'Draft'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'vessel_lenght')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_lenght', 'placeholder' => 'Lenght'])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'vessel_beam')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_beam', 'placeholder' => 'Beam'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'vessel_air_draft')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_air_draft', 'placeholder' => 'Air Draft'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($reviews, 'vessel_sail')->textInput(['maxlength' => 255, 'class' => 'form-control input-lg js-vessel_sail', 'placeholder' => 'Sail/Power'])->label(false) ?>
            </div>
        </div>
    </div>
    
    <?= $form->field($reviews, 'approved')->dropDownList([Reviews::APPROVED_FALSE => 'False', Reviews::APPROVED_TRUE => 'True']) ?>
    <div class="form-group">
        <?= Html::submitButton($reviews->isNewRecord ? Yii::t('reviews', 'Submit') : Yii::t('reviews', 'Submit'), ['class' => $reviews->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>