<?php
use yii\helpers\Html;
use common\models\Yacht;
?>
<section class="container-fluid blue-block-btns">
    <div class="row">
        <div class="container">
            <p class="title">
                <?= Yii::t('yacht', ' Would you like to have a Blog where crew or owners can make posts?') ?>
            </p>
            <div class="row">
                <div class="col-md-2 col-md-offset-4">

                    <?= Html::checkbox('enable_blog', ($model->enable_blog == Yacht::ENABLE_BLOG_TRUE) ? true : false, ['value' => Yacht::ENABLE_BLOG_TRUE, 'class' => 'js-button-yes-no', 'style' => 'display:none;']) ?>
                    <button class="js-yes-btn red-btn <?= ($model->enable_blog == Yacht::ENABLE_BLOG_TRUE && $model->id != '') ? 'active' : '';?>"><?= Yii::t('yacht', 'Yes') ?></button>
                </div>
                <div class="col-md-2">
                    <button class="js-no-btn blue-btn <?= ($model->enable_blog == Yacht::ENABLE_BLOG_FALSE && $model->id != '') ? 'active' : '';?>"><?= Yii::t('yacht', 'No') ?></button>
                </div>
            </div>
        </div>
    </div>
</section>
