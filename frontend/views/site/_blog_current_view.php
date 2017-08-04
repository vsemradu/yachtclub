<?php
use yii\helpers\Url;

?>

<!-- blog item -->
<div class="blog-item">
    <div class="photo">
        <a href="<?= Url::to(['/site/blog-view/', 'id' => $model->id]) ?>">
            <img src="<?= $model->imageUrl; ?>" alt="boat">
        </a>
    </div>

    <a href="<?= Url::to(['/site/blog-view/', 'id' => $model->id]) ?>" class="blue-row"><?= $model->title ?></a>
    <p class="gray-row date"><?= $model->dateCreate ?></p>

    <div class="text">
        <?= $model->getLittleDescription(300) ?>
    </div>
</div>
<!-- end item -->

