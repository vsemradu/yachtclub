<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<!-- blog - single post -->

<div class="container blog-single">
    <p class="wave-title">
        <?= \Yii::t('blog', 'BLOG'); ?>
    </p>

    <div class="row">
        <div class="col-md-12">
            <div class="photo-single">
                <img width="100%" src="<?= $model->imageUrl; ?>" alt="boat">
            </div>

            <div class="blog-item">
                <p class="blue-row"><?= $model->title ?></p>
                <p class="gray-row date"><?= $model->dateCreate ?></p>

                <div class="text">
                    <?= $model->description ?>
                </div>
            </div>
        </div>



        <div class="col-md-12">
            <ul class="navigation">
                <?php if (!empty($modelPrev->id)) { ?>
                    <li class="left">
                        <a href="<?= Url::toRoute(['site/blog-view', 'id' => $modelPrev->id]); ?>"><i class="ion-chevron-left"></i> Previous Article</a>
                    </li>
                <?php } ?>
                <?php if (!empty($modelNext->id)) { ?>
                    <li class="right">
                        <a href="<?= Url::toRoute(['site/blog-view', 'id' => $modelNext->id]); ?>">Next Article <i class="ion-chevron-right"></i></a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="col-md-12">
            <?php if (!empty(Yii::$app->user->id)) { ?>
                <div class="blog-post-form">

                    <?php
                    $form = ActiveForm::begin();

                    ?>

                    <?= $form->field($modelBlogComment, 'text')->textArea() ?>


                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('blog', 'Send'), ['class' => 'blue-btn']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            <?php }

            ?>
        </div>

        <div class="col-md-12">
            <div class="comments">

                <p class="title">
                    <?= \Yii::t('blog', 'COMMENTS'); ?>

                <sm>
                    <?= $modelCount?>   <?= \Yii::t('blog', 'comments'); ?>
                </sm>
                </p>

            </div>

            <div class="blog-post-comments">
                <?php \yii\widgets\Pjax::begin(['id' => 'blog-comments']); ?>
                <?=
                yii\widgets\ListView::widget([
                    'dataProvider' => $dataProviderBlogComments,
                    'itemView' => '_blog_view_comments',
                    'layout' => "{items}\n{pager}",
                    'emptyText'=>'',
                ]);

                ?>
                <?php \yii\widgets\Pjax::end(); ?>


            </div>
        </div>

    </div>

</div>



