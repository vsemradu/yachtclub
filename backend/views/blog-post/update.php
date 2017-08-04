<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */

$this->title = Yii::t('blog', 'Update ' . $model->title);
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blog Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('blog', 'Update');

?>
<div class="blog-post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'modelImage' => $modelImage,
    ])

    ?>

</div>
