<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\LocalInfo */

$this->title = $model->area_name;

?>

<?=
$this->render('_map', [
    'model' => $model,
    'weather' => 1,
]);

?>



<br>

<?=
$this->render('_menu', [
    'model' => $model,
]);

?>



<section class="container-fluid blue-section-second second">
    <div class="row">
        <div class="container js-weather-block">
            <p class="title second">
                <?= \Yii::t('localInfo', 'Please click on the map above for detailed weather and tide (for ocean/sea surface) information'); ?>
            </p>



        </div>


    </div>
</section>