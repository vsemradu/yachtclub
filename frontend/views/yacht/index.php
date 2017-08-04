<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\YachtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yacht', 'Yachts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yacht-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('yacht', 'Create Yacht'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'type_id',
            'type',
            'subtype',
            // 'name',
            // 'year',
            // 'yacht_build',
            // 'home_port',
            // 'length',
            // 'beam',
            // 'draft',
            // 'air_draft',
            // 'website',
            // 'summary',
            // 'background_image_id',
            // 'enable_blog',
            // 'charter_company',
            // 'contact_info',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
