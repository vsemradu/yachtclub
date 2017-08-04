<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use dosamigos\ckeditor\CKEditor;
use skeeks\widget\chosen\Chosen;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\LocalInfo */

$this->title = Yii::t('localInfo', 'Create Local Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('localInfo', 'Local Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<script>
    var apiGoogleKey = '<?= Yii::$app->params['apiGoogleKey'] ?>';
</script>
<script src="/backend/js/google_map.js"></script>
<div class="local-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="width: 1110px; height: 500px; position: absolute;clear: both;" class="map-canvas off" id="js-map-canvas"></div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <div class="local-info-form">

        <?php
        $form = ActiveForm::begin([
                'id' => 'js-form-block-address',
                'options' => ['enctype' => 'multipart/form-data']
        ]);

        ?>

        <?= $form->field($model, 'location_lat')->hiddenInput(['maxlength' => true, 'id' => 'js-lat'])->label(false) ?>

        <?= $form->field($model, 'location_lng')->hiddenInput(['maxlength' => true, 'id' => 'js-lng'])->label(false) ?>

        <?= $form->field($model, 'zoom')->hiddenInput(['id' => 'js-zoom'])->label(false) ?>

        <?= $form->field($model, 'area_box_ne_lat')->hiddenInput(['maxlength' => true, 'id' => 'js-ne_lat'])->label(false) ?>

        <?= $form->field($model, 'area_box_sw_lat')->hiddenInput(['maxlength' => true, 'id' => 'js-sw_lat'])->label(false) ?>

        <?= $form->field($model, 'area_box_ne_lng')->hiddenInput(['maxlength' => true, 'id' => 'js-ne_lng'])->label(false) ?>

        <?= $form->field($model, 'area_box_sw_lng')->hiddenInput(['maxlength' => true, 'id' => 'js-sw_lng'])->label(false) ?>



        <div id="js-form-address" style="display: none;">
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
                'items' => [],
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
                'items' => [],
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
        </div>
        <?php ActiveForm::end(); ?>

    </div>


</div>

<?php
Modal::begin([
    'header' => '<h2>Choose the address from the list</h2>',
    'toggleButton' => false,
    'id' => 'js-address-modal'
]);

echo Html::dropDownList('adress', null, [], ['id' => 'js-address-list', 'prompt' => '']);

Modal::end();

?>
