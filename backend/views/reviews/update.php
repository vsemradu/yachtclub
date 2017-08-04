<?php
use yii\helpers\Html;
use common\models\Reviews;

/* @var $this yii\web\View */
/* @var $model common\models\Reviews */

$this->title = Yii::t('reviews', 'Update {modelClass} ', [
        'modelClass' => 'Review',
    ]);


if ($model->type == Reviews::TYPE_BUSINESS) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('reviews', 'Reviews'), 'url' => ['index-business']];
} elseif ($model->type == Reviews::TYPE_PIN) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('reviews', 'Reviews'), 'url' => ['index-pin']];
} else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('reviews', 'Reviews'), 'url' => ['index-yacht']];
}



$this->params['breadcrumbs'][] = Yii::t('reviews', 'Update');

?>
<div class="reviews-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if ($model->type == Reviews::TYPE_BUSINESS) {
        echo $this->render('review_form_busines', [
            'reviews' => $model,
        ]);
    } elseif ($model->type == Reviews::TYPE_PIN) {
        echo $this->render('review_form_pin_busines', [
            'reviews' => $model,
        ]);
    } else {
        echo $this->render('review_form_yacht', [
            'reviews' => $model,
        ]);
    }

    ?>

</div>
