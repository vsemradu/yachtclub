<?php
use yii\helpers\Url;

?>
<!-- blog item -->

<div class="blog-item">
    <div class="row">
        <div class="col-lg-7 col-md-5">
            <div class="photo">
                <a href="<?= Url::to(['/site/blog-view/', 'id'=>$model->id])?>">
                    <img src="<?= $model->imageUrl; ?>" alt="boat">
                </a>
            </div>
        </div>
        <div class="col-lg-5 col-md-7">
            <a href="<?= Url::to(['/site/blog-view/', 'id'=>$model->id])?>" class="blue-row"><?= $model->title ?></a>
            <p class="gray-row date"><?= $model->dateCreate ?></p>

            <div class="text">
                <?= $model->littleDescription ?>
            </div>
        </div>
    </div>
</div>
<!-- end item -->