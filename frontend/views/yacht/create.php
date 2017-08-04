<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Yacht */

$this->title = Yii::t('yacht', 'Create Yacht');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yacht', 'Yachts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yacht-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
