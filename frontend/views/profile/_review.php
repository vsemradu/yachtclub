<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<div class="col-md-12 review">


    <div class="review-item">
        <div class="media">
            <div class="media-left">

                <?php if (!empty($model->user->userInfo->imageUrl)) { ?>
                    <div class="photo" style="background:url(<?= $model->user->userInfo->imageUrl ?>)no-repeat center;background-size:cover;"></div>
                <?php } else { ?>
                    <div class="photo">
                        <img src="<?php echo Url::toRoute('/img/ph.png'); ?>" alt="">
                    </div>
                <?php } ?>

            </div>
            <div class="media-body">
                <p class="title">
                    <?= $model->user->userInfo->fullName ?>
                </p>
                <div class="posted-text">
                    <?= $model->dateCreate ?>
                </div>
            
                <div class="text">
                       <b><?= $model->title; ?></b><br>
                    <?= $model->text ?>

                    <a href="<?= $model->topicUrl ?>" class="blue-btn">
                        <?= \Yii::t('review', 'view topic'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>