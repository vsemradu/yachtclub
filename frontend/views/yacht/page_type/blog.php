<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */
if (!empty($model->id) && $model->enable_blog == \common\models\Yacht::ENABLE_BLOG_TRUE) {

    ?>
    <a href="javascript:;" class="add-review-btn js-blog-add">
        <?= Yii::t('yacht', '+Add Blog Post') ?>
    </a>

    <div class="container js-blog-block create-pin" style="<?php echo isset($modelBlogPost->title) ? '' : 'display:none;'; ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="page-preview">
                    <div class="head">
                        <?= Yii::t('yacht', 'Blog Post') ?>
                    </div>

                    <?php
                    $form = ActiveForm::begin([
                            'options' => ['enctype' => 'multipart/form-data'],
                            'validateOnSubmit' => false,
                    ]);

                    ?>
                    <div class="upload clearfix">



                        <?= $form->field($modelBlogPost, 'title')->textInput(['maxlength' => 255])->label(false) ?>
                    </div>
                    <?=
                    $form->field($modelBlogPost, 'description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'basic'
                    ])->label(false)

                    ?>

                    <div class="upload clearfix">


                        <?=
                        FileInput::widget([
                            'model' => $modelBlogPostImage,
                            'attribute' => '[\'blog\']upload_image',
                            'options' => [

                                'accept' => 'image/*',
                                'multiple' => false,
                                'id' => uniqid()
                            ],
                            'pluginOptions' => [
                                'showRemove' => false,
                                'showUpload' => false,
                            ],
                        ])

                        ?>
                        <div style="color: #A94442;">
                            <?= Html::error($modelBlogPostImage, 'upload_image') ?>
                        </div>

                    </div>
                    <div class="form-group text-center">
                        <?= Html::submitButton(Yii::t('blog', 'Add'), ['class' => 'blue-btn']) ?>
                    </div>
                    <?= Html::hiddenInput('add_blog', 1) ?>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="container create-pin">
        <div class="row">
            <div class="col-md-12">
                <div class="page-preview clearfix">
                    <div class="head">
                        <?= Yii::t('yacht', 'Yacht Blog') ?>
                    </div>

                    <div class="col-md-12">
                        <div class="row edit-location first" style="color: #000;">


                            <?php yii\widgets\Pjax::begin(['id' => 'blogs_yacht']) ?>
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProviderBlogPost,
                                'filterModel' => $searchModelBlogPost,
                                'columns' => [
                                    //            ['class' => 'yii\grid\SerialColumn'],
                                    //            'id',
                                    //            'image_id',
                                    'title',
                                    'description:html',
                                    // 'type',
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{update}{delete}',
                                        'buttons' => [
                                            'delete' => function ($url, $blog) {
                                                $customurl = Yii::$app->getUrlManager()->createUrl(['yacht/delete-blog']);
                                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $customurl, [
                                                        'title' => Yii::t('yii', 'Delete'),
                                                        'data-id' => $blog['id'],
                                                        'class' => 'js-remove-blog-yacht',
                                                ]);
                                            },
                                                'update' => function ($url, $blog) {
                                                $customurl = Yii::$app->getUrlManager()->createUrl(['blog-post/update', 'id' => $blog['id']]);
                                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $customurl, [
                                                        'title' => Yii::t('yii', 'Update'),
                                                        'target' => '_blank',
                                                ]);
                                            },
                                            ]
                                        ],
                                    ],
                                ]);

                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <?php \yii\widgets\Pjax::end(); ?>
        <?php } ?>
