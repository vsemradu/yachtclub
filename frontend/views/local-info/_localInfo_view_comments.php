<?php
use yii\helpers\Url;

?>
<div class="comment-item">
    <div class="media">
        <div class="media-left">
            <div class="photo">

                <?php if (!empty($model->user->userInfo->imageUrl)) { ?>
                    <img alt="" src="<?= $model->user->userInfo->imageUrl ?>">
                <?php } else { ?>
                    <img alt="" src="<?= Url::to('/img/ph.png') ?>">
                <?php } ?>

            </div>
        </div>
        <div class="media-body">
            <p class="blue-row">
                <?= $model->user->userInfo->fullName ?>
            </p>
            <div class="gray-row">
                <?= $model->dateCreate ?>
            </div>

            <div class="text">
                <?= $model->text ?>

            </div>

            <?php if (!empty(Yii::$app->user->id) && $model->user->id == Yii::$app->user->id) { ?>
                <a class="js-delete-comment-localInfo blue-btn" href="<?= Url::toRoute(['/local-info/ajax-delete-localinfo-comment', 'id' => $model->id]) ?>"> <?= \Yii::t('localInfo', 'Delete'); ?> </a>
            <?php } ?>
        </div>
    </div>
</div>



