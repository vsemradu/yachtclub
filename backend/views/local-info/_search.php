<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LocalInfoSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="local-info-search">

    <?php
    $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
    ]);

    ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'location_lat') ?>

    <?= $form->field($model, 'location_lng') ?>

    <?= $form->field($model, 'zoom') ?>

    <?= $form->field($model, 'area_box_ne_lat') ?>

    <?php // echo $form->field($model, 'area_box_sw_lat')  ?>

    <?php // echo $form->field($model, 'area_box_ne_lng')  ?>

    <?php // echo $form->field($model, 'area_box_sw_lng')  ?>

    <?php // echo $form->field($model, 'area_name')  ?>

    <?php // echo $form->field($model, 'type_of_address')  ?>

    <?php // echo $form->field($model, 'summary')  ?>

    <?php // echo $form->field($model, 'customs_immigrations')  ?>

    <?php // echo $form->field($model, 'marine_laws_regulations')  ?>

    <?php // echo $form->field($model, 'local_life')  ?>

    <?php // echo $form->field($model, 'image_id')  ?>

    <?php // echo $form->field($model, 'featured_business_id')  ?>

    <?php // echo $form->field($model, 'local_life_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('localInfo', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('localInfo', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
