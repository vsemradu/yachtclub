<?php
use common\models\Pin;
use common\models\PinField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\rating\StarRating;

?>
<div class="col-md-12">
    <div class="row edit-location">
        <div class="media rating">
            <div class="media-left">
                <label>
                    <?= \Yii::t('createPin', 'Choose a Rating'); ?> <span class="red">*</span>
                </label>
            </div>
            <div class="media-body">
                <?=
                $form->field($pinField, 'rating')->widget(StarRating::classname(), [
                    'pluginOptions' => [
                        'disabled' => false,
                        'showClear' => false,
                        'step' => 1,
                        'showCaption' => false,
                        'glyphicon' => false,
                        'symbol' => '',
                    ]
                ])->label(false);

                ?>
            </div>
        </div>
    </div>
</div>

<style>
    .rating-container .rating-stars { color: #225178; }
    .star-rating { font-size: 24px; font-weight: bold; line-height: 45px; }
</style>