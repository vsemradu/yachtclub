<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */

$this->title = Yii::t('blog', 'Update '. $model->title);
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blog Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'Update');

?>
<div class="blog-post-update">
    
    <p class="wave-title">
        <?= Html::encode($this->title) ?>    </p>
    
    
    <div class="container">
        <?=
            $this->render('_form', [
                'model' => $model,
                'modelImage' => $modelImage,
            ])

        ?>
    </div>
    
    

</div>
