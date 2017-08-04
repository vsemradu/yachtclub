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

$yachts = ArrayHelper::map(Yacht::findAll(['user_id' => Yii::$app->user->id, 'share' => Yacht::SHARE_TRUE]), 'id', 'name');

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


        <?php
        if (!empty($rate_two_star)) {
            $pluginEvents = [
                "rating.change" => "function(event, value, caption) {
                    if(value < 3){
                    alert('Can we help you to improve your experience with this business? Please contact us at " . $model->phone . "/" . $model->website . " to see if we could be of any help for you.');
                    }
                }",
            ];
        } else {
            $pluginEvents = [];
        }
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
            'pluginEvents' => $pluginEvents
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
    <br>
    <?php if (!empty($yachts)) { ?>
        <div class="label-rating">
            <?= \Yii::t('reviews', 'Select yacht:'); ?> <?= Html::dropDownList('yacht', null, $yachts, ['prompt' => '', 'class' => 'js-yacht-select']) ?>
        </div>
    <?php } ?>

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
    <div class="row">
        <div class="col-md-12 text-center">
            <button type="submit" class="blue-btn"><?= \Yii::t('reviews', 'Submit'); ?></button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>