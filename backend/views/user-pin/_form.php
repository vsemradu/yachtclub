<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserPin;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model common\models\UserPin */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-pin-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-7">
            <br>
            <p><strong><?= \Yii::t('pin', 'Type:'); ?></strong> <?= UserPin::itemAlias('type_name', $model->type) ?></p>

            <p><strong><?= \Yii::t('pin', 'Name:'); ?></strong> <?= $model->pinField->name ?></p>
            <p><strong><?= \Yii::t('pin', 'GPS Coordinates:'); ?></strong> <?= $model->latConvert ?> S / <?= $model->lanConvert ?> E</p>


            <?php if (!empty($model->pinField->ratingList)) { ?>
                <p><strong><?= \Yii::t('pin', 'Rating:'); ?></strong> <?= $model->pinField->ratingList ?></p>
            <?php } ?>


            <?php if (!empty($model->pinField->location)) { ?>
                <p><strong><?= \Yii::t('pin', 'Location:'); ?></strong> <?= $model->pinField->location ?></p>
            <?php } ?>

            <?php if (!empty($model->pinField->breakList)) { ?>
                <p><strong><?= \Yii::t('pin', 'Break:'); ?></strong> <?= $model->pinField->breakList ?></p>
            <?php } ?>

            <?php if (!empty($model->pinField->max_depth)) { ?>
                <p><strong><?= \Yii::t('pin', 'Max. Depth:'); ?></strong> <?= $model->pinField->max_depth ?> <?= \common\models\PinField::itemAlias('vessel_type', $model->pinField->max_depth_type) ?></p>
            <?php } ?>

            <?php if (!empty($model->pinField->visibilityList)) { ?>
                <p><strong><?= \Yii::t('pin', 'Visibility'); ?></strong> <?= $model->pinField->visibilityList ?></p>
            <?php } ?>


            <?php if (!empty($model->pinField->dive_operator_name)) { ?>
                <p><strong><?= \Yii::t('pin', ' Dive Operator Name:'); ?></strong> <?= $model->pinField->dive_operator_name ?></p>
            <?php } ?>
            <?php if (!empty($model->pinField->dive_operator_address)) { ?>
                <p><strong><?= \Yii::t('pin', ' Dive Operator Address:'); ?></strong> <?= $model->pinField->dive_operator_address ?></p>
            <?php } ?>



            <?php if (!empty($model->pinField->vessel_lenght)) { ?>
                <p><strong><?= \Yii::t('pin', ' Max. Vessel Length:'); ?></strong> <?= $model->pinField->vessel_lenght ?></p>
            <?php } ?>


            <?php if (!empty($model->pinField->vessel_draft)) { ?>
                <p><strong><?= \Yii::t('pin', ' Max. Vessel Draft:'); ?></strong> <?= $model->pinField->vessel_draft ?></p>
            <?php } ?>

            <?php if (!empty($model->pinField->quality_rating)) { ?>
                <p><strong><?= \Yii::t('pin', 'Fuel Quality Rating:'); ?></strong> <?= $model->pinField->qualityRatingList ?></p>
            <?php } ?>

            <?php if (!empty($model->pinField->resourcesWithinList)) { ?>
                <p><strong><?= \Yii::t('pin', 'Resources within a short tender ride:'); ?></strong> <?= $model->pinField->resourcesWithinList ?></p>
            <?php } ?>



            <?php if (!empty($model->pinField->fuel_price)) { ?>
                <p><strong><?= \Yii::t('pin', 'Fuel Price:'); ?></strong> <?= $model->pinField->fuel_price ?></p>
            <?php } ?>

            <?php if (!empty($model->pinField->water_price)) { ?>
                <p><strong><?= \Yii::t('pin', 'Water Price:'); ?></strong> <?= $model->pinField->water_price ?></p>
            <?php } ?>

            <?php if (!empty($model->pinField->howSevereList)) { ?>
                <p><strong><?= \Yii::t('pin', 'How severe:'); ?></strong> <?= $model->pinField->howSevereList ?></p>
            <?php } ?>
            <?php if (!empty($model->description)) { ?>
                <p><strong><?= \Yii::t('pin', 'Comments and Tips:'); ?></strong> <?= $model->description ?></p>
            <?php } ?>

                <p><strong><?= \Yii::t('pin', 'Rating Pin:'); ?></strong>
                    <?=
                    StarRating::widget(['model' => $model->pinField, 'attribute' => 'rating',
                        'pluginOptions' => [
                            'disabled' => true,
                            'showClear' => false,
                            'step' => 1,
                            'showCaption' => false,
                            'glyphicon' => false,
                            'symbol' => '',
                        ]
                    ]);

                    ?>
                </p>

        </div>
    </div>
    <br>
    <?= $form->field($model, 'approved')->dropDownList([UserPin::APPROVED_FALSE => 'False', UserPin::APPROVED_TRUE => 'True']) ?>
    <?= $form->field($modelField, 'summary')->textArea(['rows' => 8]) ?>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('userPin', 'Create') : Yii::t('userPin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
