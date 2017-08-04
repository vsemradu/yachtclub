<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserPin */

$this->title = Yii::t('userPin', 'Update ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('userPin', 'Pins'), 'url' => ['index']];

$this->params['breadcrumbs'][] = Yii::t('userPin', 'Update');

?>
<div class="user-pin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
         'modelField' => $modelField,
    ])

    ?>

</div>
