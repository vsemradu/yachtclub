<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LocalInfoCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('localInfoComment', 'Tip or Trick');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="local-info-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //TODO: Remove commented code
//        'filterModel' => $searchModel,
        'columns' => [

            [
                'label' => 'Local page name',
                'attribute' => 'localInfo.area_name',
                'value' => 'localInfo.area_name',
                'filter' => false,
                'enableSorting' => false,
            ],
            [
                'label' => 'User',
                'attribute' => 'user.userInfo.fullName',
                'value' => 'user.userInfo.fullName',
                'filter' => false,
                'enableSorting' => false,
            ],
            [
                'label' => 'Text',
                'attribute' => 'text',
                'value' => 'text',
                'filter' => false,
                'enableSorting' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'
            ],
        ],
    ]);

    ?>

</div>
