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
        <div class="col-md-12 text-center">
            <button type="submit" class="blue-btn"><?= \Yii::t('reviews', 'Submit'); ?></button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>