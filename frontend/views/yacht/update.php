<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Yacht */

$this->title = Yii::t('yacht', 'Update {modelClass}: ', [
    'modelClass' => 'Yacht',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yacht', 'Yachts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yacht', 'Update');
?>
<div class="yacht-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
