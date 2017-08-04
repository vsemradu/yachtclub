<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\BusinessHappyHour;

$uniqid = !empty($model->id) ? $model->id : uniqid();

?>

<div class="js-happy-hours-block">
    <div class="row edit-location">
        <div class="col-md-12">

            <div class="select-white">
                <?= Html::activeDropDownList($model, '[' . $uniqid . ']week', BusinessHappyHour::itemAlias('week_title'), ['class' => 'form-control single-input', 'placeholder' => \Yii::t('yacht', 'Week*'), 'label' => false]) ?>
            </div>
            <div style="color: #a94442" class="offset-error">         <?= Html::error($model, 'week') ?>   </div>
        </div>
    </div>
    <br>
    <div class="row edit-location">
        <div class="col-md-12">

            <?= Html::activeTextarea($model, '[' . $uniqid . ']special', ['class' => 'form-control single-input', 'placeholder' => \Yii::t('yacht', 'Special*'), 'label' => false]) ?>
            <div style="color: #a94442" class="offset-error">         <?= Html::error($model, 'special') ?>   </div>
        </div>

    </div>


    <?php if (!empty($remove)) { ?>
        <a href="#" class="add-review-btn js-remove" data-id="<?php echo!empty($model->id) ? $model->id : ''; ?>" data-business_id="<?php echo!empty($business->id) ? $business->id : ''; ?>" >- Remove</a>
    <?php } ?>
    <hr>
</div>