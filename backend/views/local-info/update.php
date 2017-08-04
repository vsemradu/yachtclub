<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use dosamigos\ckeditor\CKEditor;
use skeeks\widget\chosen\Chosen;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\LocalInfo */

$this->title = Yii::t('localInfo', 'Update Local Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('localInfo', 'Local Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="local-info-create">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="local-info-form">

        <?php
        $form = ActiveForm::begin([
                'id' => 'js-form-block-address',
                'options' => ['enctype' => 'multipart/form-data']
        ]);

        ?>




        <?= $form->field($model, 'area_name')->textInput(['maxlength' => true, 'id' => 'js-area_name']) ?>
        <?=
        $form->field($model, 'summary')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ])

        ?>

        <?=
        $form->field($model, 'customs_immigrations')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ])

        ?>

        <?=
        $form->field($model, 'marine_laws_regulations')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ])

        ?>
        <?=
        $form->field($model, 'local_life')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ])

        ?>

        <?=
        $form->field($model, 'featured_id')->widget(
            Chosen::className(), [
            'items' => $businesList,
            'multiple' => true,
            'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
            'clientOptions' => [
                'search_contains' => true,
                'single_backstroke_delete' => false,
            ],
            'options' => [
                'id' => 'js-featured_business_id',
            ]
        ]);

        ?>

        <?=
        $form->field($model, 'local_id')->widget(
            Chosen::className(), [
            'items' => $businesList,
            'multiple' => true,
            'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
            'clientOptions' => [
                'search_contains' => true,
                'single_backstroke_delete' => false,
            ],
            'options' => [
                'id' => 'js-local_life_id',
            ]
        ]);

        ?>
        <p class="text">
            <?= \Yii::t('business', ' Upload flag'); ?>

        </p>

        <div class="photos">
            <?php if (!empty($model->image_id)) { ?>
                <div data-id="<?= $model->image_id ?>" class="item js-delete-fon-photo">
                    <img src="<?= $model->image->adminImageUrl ?>" width="200" alt="">
                    <!-- this is delete button -->
                    <a href="#" class="data-photo-overlay">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    <!-- end button -->
                </div>
            <?php } ?>

        </div>
        <?=
        $form->field($image, 'upload_image')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
                'multiple' => false,
                'id' => uniqid()
            ],
            'pluginOptions' => [
                'showRemove' => false,
                'showUpload' => false,
            ],
        ])->label(false);

        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('localInfo', 'Create') : Yii::t('localInfo', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>

<script>
    $(function () {


        $('.js-delete-fon-photo').click(function () {

            if (confirm("Are you sure to delete?")) {
                var photo_id = $(this).data('id');
                var block = this;
                $.get("/backend/local-info/ajax-delete-fon-photo", {local_id: <?= $model->id ?>, photo_id: photo_id})
                        .done(function (data) {
                            $(block).remove();

                        });
            }

        });



    });


</script>