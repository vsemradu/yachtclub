<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\file\FileInput;
use common\models\CrewMemberRole;

?>
<div class="col-lg-6">
    <div class="blog-item">
        <div class="row">
            <div class="col-md-6">
                <div class="photo">
                    <a href="<?= Url::to(['/site/blog-view/', 'id' => $model->id]) ?>">
                        <img src="<?= $model->imageUrl; ?>" alt="boat">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <a href="<?= Url::to(['/site/blog-view/', 'id' => $model->id]) ?>" class="blue-row"><?= $model->title ?></a>
                <p class="gray-row date"><?= $model->dateCreate ?></p>

                <div class="text">
                    <?= $model->littleDescription ?>
                </div>
            </div>
        </div>
    </div>