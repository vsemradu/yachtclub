<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\UserPin;
use common\models\Reviews;
use kartik\rating\StarRating;
use kartik\file\FileInput;

?>

<?php if (!empty($reviews->getErrors())) { ?>
    <script>
        $(function () {
            $.scrollTo('.js-add-review', 500);
        });
    </script>
<?php } ?>
<a href="#" class="js-add-review add-review-btn">
    <?= \Yii::t('reviews', '  + Add Review'); ?>
</a>



<div class="js-add-review-block container add-reviews" style="<?php echo!empty($reviews->user_id) ? '' : 'display: none;'; ?>">

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
    <?=
    FileInput::widget([
        'model' => $image,
        'attribute' => 'upload_image[]',
        'options' => [

            'accept' => 'image/*',
            'multiple' => true,
            'id' => uniqid()
        ],
        'pluginOptions' => [
            'showRemove' => false,
            'showUpload' => false,
        ],
    ])

    ?>

    <div class="rating-choose">
        <div class="label-rating">
            <?= \Yii::t('reviews', '  Choose a Rating <span>*</span>'); ?>
        </div>


        <?=
        StarRating::widget(['model' => $reviews, 'attribute' => 'rating',
            'pluginOptions' => [
                'disabled' => false,
                'showClear' => false,
                'step' => 1,
                'showCaption' => false,
                'glyphicon' => false,
                'symbol' => '',
                'id' => uniqid(),
            ]
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
    <div class="review-hr"></div>
    <div class="label-rating">
        <?= \Yii::t('reviews', ' How where these features?<span>*</span>'); ?>
    </div>

    <div class="rating-choose-sm">
        <div class="label-rating">
            <?= \Yii::t('reviews', 'Crew'); ?>
        </div>
        <?=
        StarRating::widget(['model' => $reviews, 'attribute' => 'rating_crew',
            'pluginOptions' => [
                'disabled' => false,
                'showClear' => false,
                'step' => 1,
                'showCaption' => false,
                'glyphicon' => false,
                'symbol' => '',
                'id' => uniqid(),
            ]
        ]);

        ?>
        <div class="form-group field-reviews-text required has-error">
            <p class="help-block help-block-error"> <?= Html::error($reviews, 'rating_crew') ?></p>
        </div>
    </div>

    <div class="rating-choose-sm">
        <div class="label-rating">
            <?= \Yii::t('reviews', 'Food'); ?>
        </div>
        <?=
        StarRating::widget(['model' => $reviews, 'attribute' => 'rating_food',
            'pluginOptions' => [
                'disabled' => false,
                'showClear' => false,
                'step' => 1,
                'showCaption' => false,
                'glyphicon' => false,
                'symbol' => '',
                'id' => uniqid(),
            ]
        ]);

        ?>
        <div class="form-group field-reviews-text required has-error">
            <p class="help-block help-block-error"> <?= Html::error($reviews, 'rating_food') ?></p>
        </div>
    </div>

    <div class="rating-choose-sm">
        <div class="label-rating">
            <?= \Yii::t('reviews', 'Cleanliness'); ?>
        </div>
        <?=
        StarRating::widget(['model' => $reviews, 'attribute' => 'rating_cleanliness',
            'pluginOptions' => [
                'disabled' => false,
                'showClear' => false,
                'step' => 1,
                'showCaption' => false,
                'glyphicon' => false,
                'symbol' => '',
                'id' => uniqid(),
            ]
        ]);

        ?>
        <div class="form-group field-reviews-text required has-error">
            <p class="help-block help-block-error"> <?= Html::error($reviews, 'rating_cleanliness') ?></p>
        </div>
    </div>

    <div class="rating-choose-sm">
        <div class="label-rating">
            <?= \Yii::t('reviews', 'Enjoyability'); ?>
        </div>
        <?=
        StarRating::widget(['model' => $reviews, 'attribute' => 'rating_enjoyability',
            'pluginOptions' => [
                'disabled' => false,
                'showClear' => false,
                'step' => 1,
                'showCaption' => false,
                'glyphicon' => false,
                'symbol' => '',
                'id' => uniqid(),
            ]
        ]);

        ?>
        <div class="form-group field-reviews-text required has-error">
            <p class="help-block help-block-error"> <?= Html::error($reviews, 'rating_enjoyability') ?></p>
        </div>
    </div>

    <div class="rating-choose-sm">
        <div class="label-rating">
            <?= \Yii::t('reviews', ' Maintance - boat up keep '); ?>
        </div>
        <?=
        StarRating::widget(['model' => $reviews, 'attribute' => 'rating_maintenance',
            'pluginOptions' => [
                'disabled' => false,
                'showClear' => false,
                'step' => 1,
                'showCaption' => false,
                'glyphicon' => false,
                'symbol' => '',
                'id' => uniqid(),
            ]
        ]);

        ?>
        <div class="form-group field-reviews-text required has-error">
            <p class="help-block help-block-error"> <?= Html::error($reviews, 'rating_maintenance') ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button type="submit" class="blue-btn"><?= \Yii::t('reviews', 'Submit'); ?></button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>