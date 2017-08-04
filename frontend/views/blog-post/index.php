<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BlogPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'Blog Posts');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="blog-post-index">
    
    <div class="container">
        <br><br><br>
        <div class="row">
            <div class="col-md-12 create-pin">
                <div class="page-preview clearfix">
                    <div class="head">
                        <?= Html::encode($this->title) ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row edit-location first" style="color: #000;">

                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    'title',
                                    'description:html',
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{update}{delete}',
                                    ],
                                ],
                            ]);

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

</div>
