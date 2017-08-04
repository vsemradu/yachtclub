<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LocalInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('localInfo', 'Busines');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="local-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Busines name',
                'attribute' => 'business_name',
                'value' => 'businessName',
                'format' => 'raw'
            ],
            'address',
            'phone',
            'summary',
//            [
//                'label' => 'Area name',
//                'attribute' => 'area_name',
//                'value' => 'areaName',
//                'format' => 'raw'
//            ],
//            'area_name',
        ],
    ]);

    ?>

</div>
