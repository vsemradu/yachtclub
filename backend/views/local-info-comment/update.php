<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LocalInfoComment */

$this->title = Yii::t('localInfoComment', 'Update {modelClass}', [
    'modelClass' => 'Tip or Trick',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('localInfoComment', 'Tip or Trick'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('localInfoComment', 'Update');
?>
<div class="local-info-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
