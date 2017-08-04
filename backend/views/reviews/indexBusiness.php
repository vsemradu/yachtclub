<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReviewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('reviews', 'Business Reviews');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="reviews-index">

    <h1><?= Html::encode($this->title) ?> Waiting For Approval</h1>

    <?php \yii\widgets\Pjax::begin(); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProviderApprovedWaiting,
        'filterModel' => $searchModelApprovedWaiting,
        'columns' => [

            [
                'label' => 'User',
                'attribute' => 'userInfoFullName',
                'value' => 'userInfoFullName',
            ],
            [
                'label' => 'Business name',
                'attribute' => 'businessBusinessName',
                'value' => 'businessBusinessName',
            ],
            [
                'label' => 'Text',
                'attribute' => 'text',
                'value' => 'littleText',
                'filter' => true,
                'enableSorting' => false,
            ],
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
<div class="reviews-index">

    <h1><?= Html::encode($this->title) ?> Approved</h1>

    <?php \yii\widgets\Pjax::begin(); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProviderApprovedTrue,
        'filterModel' => $searchModelApprovedTrue,
        'columns' => [

            [
                'label' => 'User',
                'attribute' => 'userInfoFullName',
                'value' => 'userInfoFullName',
            ],
            [
                'label' => 'Business name',
                'attribute' => 'businessBusinessName',
                'value' => 'businessBusinessName',
            ],
            [
                'label' => 'Text',
                'attribute' => 'text',
                'value' => 'littleText',
                'filter' => true,
                'enableSorting' => false,
            ],
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
<div class="reviews-index">

    <h1><?= Html::encode($this->title) ?> Not Approved</h1>


    <?php \yii\widgets\Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProviderApprovedFalse,
        'filterModel' => $searchModelApprovedFalse,
        'columns' => [

            [
                'label' => 'User',
                'attribute' => 'userInfoFullName',
                'value' => 'userInfoFullName',
            ],
            [
                'label' => 'Business name',
                'attribute' => 'businessBusinessName',
                'value' => 'businessBusinessName',
            ],
            [
                'label' => 'Text',
                'attribute' => 'text',
                'value' => 'littleText',
                'filter' => true,
                'enableSorting' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'
            ],
        ],
    ]);

    ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
