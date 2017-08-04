<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserPinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('userPin', 'Pins');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-pin-index">

    <h1><?= Html::encode($this->title) ?> Waiting For Approval</h1>

    <?php \yii\widgets\Pjax::begin(); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProviderApprovedWaiting,
        'filterModel' => $searchModelApprovedWaiting,
        'columns' => [
            [
                'label' => 'Pin name',
                'attribute' => 'pinFieldName',
                'value' => 'pinFieldName',
                'format' => 'raw'
            ],
            'lat',
            'lan',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'
            ],
        ],
    ]);

    ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
<hr>
<div class="user-pin-index">

    <h1><?= Html::encode($this->title) ?> Approved</h1>

    <?php \yii\widgets\Pjax::begin(); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProviderApprovedTrue,
        'filterModel' => $searchModelApprovedTrue,
        'columns' => [
            [
                'label' => 'Pin name',
                'attribute' => 'pinFieldName',
                'value' => 'pinFieldName',
                'format' => 'raw'
            ],
            'lat',
            'lan',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'
            ],
        ],
    ]);

    ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
<hr>
<div class="user-pin-index">

    <h1><?= Html::encode($this->title) ?> Not Approved</h1>

    <?php \yii\widgets\Pjax::begin(); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProviderApprovedFalse,
        'filterModel' => $searchModelApprovedFalse,
        'columns' => [
            [
                'label' => 'Pin name',
                'attribute' => 'pinFieldName',
                'value' => 'pinFieldName',
                'format' => 'raw'
            ],
            'lat',
            'lan',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'
            ],
        ],
    ]);

    ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>