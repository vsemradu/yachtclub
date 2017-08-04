<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="blog-post-form">

    <?php
    $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
    ]);

    ?>

    <?php if (!$model->isNewRecord) { ?>
        <img src="<?= $model->imageUrl; ?>" width="300" alt="<?= $model->title; ?>">
    <?php } ?>
    <?= $form->field($modelImage, 'upload_image')->fileInput() ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?=
    $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ])

    ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
