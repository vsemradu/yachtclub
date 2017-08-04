<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\models\CrewMemberRole;
use common\models\Yacht;
use vova07\fileapi\Widget as FileAPI;

?>


<div class="col-lg-5">
    <div class="page-preview">
        <div class="head">
            <?= Yii::t('yacht', 'Upload background photo') ?>
        </div>

        <div class="upload clearfix">
            <div class="photos">
                <?php if (!empty($model->yachtImageFon)) { ?>
                    <div data-id="<?= $model->background_image_id ?>" class="item js-delete-fon-photo">
                        <img src="<?= $model->yachtImageFon->imageUrl ?>" width="200" alt="">
                        <!-- this is delete button -->
                        <a href="#" class="data-photo-overlay">
                            <i class="fa fa-trash-o"></i>
                        </a>
                        <!-- end button -->
                    </div>
                <?php } ?>

            </div>
            <?php
            echo $form->field($image, 'name')->widget(
                FileAPI::className(), [
                'settings' => [
                    'url' => ['/yacht/fileapi-upload'],
                    'onSelect' => 'function (imageFile){alert();}',
                ],
                'crop' => true,

                ]
            );

            ?>
        
        </div>
    </div>
    <div class="page-preview">
        <div class="head">
            <?= Yii::t('yacht', 'Upload photo') ?>
        </div>

        <div class="upload clearfix">


            <div class="photos">
                <?php foreach ($model->yachtImages as $yachtImages) { ?>
                    <div data-id="<?= $yachtImages->id ?>" class="item js-delete-photo">
                        <img src="<?= $yachtImages->image->imageUrl ?>" width="200" alt="">
                    </div>
                <?php } ?>
            </div>
            <p class="text">
                <?= Yacht::itemAlias('photo_label', $model->subtype) ?>
            </p>

            <?=
            FileInput::widget([
                'model' => $image,
                'attribute' => '[\'yacht\']upload_image[]',
                'options' => [

                    'accept' => 'image/*',
                    'multiple' => true,
                    'id' => uniqid()
                ],
                'pluginOptions' => [
                    'showRemove' => false,
                    'showUpload' => false,
                ],
            ])

            ?>
        </div>
    </div>

    <div class="page-preview">
        <div class="head">
            <?= Yii::t('yacht', 'Summary') ?>
        </div>



        <div class="form-group">


            <?= $form->field($model, 'summary')->textArea(['class' => 'form-control', 'rows' => "4", 'placeholder' => Yacht::itemAlias('summery_place_holder', $model->subtype)])->label(false) ?>
        </div>



    </div>
</div>


<script>
    $(function () {


        $('.js-delete-fon-photo').click(function () {

            if (confirm("Are you sure to delete?")) {
                var photo_id = $(this).data('id');
                var block = this;
                $.get("/yacht/ajax-delete-fon-photo", {yacht_id: <?= !empty($model->id) ? $model->id : 0 ?>, photo_id: photo_id})
                        .done(function (data) {
                            $(block).remove();

                        });
            }

        });


        $('.js-delete-photo').click(function () {

            if (confirm("Are you sure to delete?")) {
                var yacht_photo_id = $(this).data('id');
                var block = this;
                $.get("/yacht/ajax-delete-photo", {yacht_id: <?= !empty($model->id) ? $model->id : 0 ?>, yacht_photo_id: yacht_photo_id})
                        .done(function (data) {
                            $(block).remove();

                        });
            }

        });
    });


</script>