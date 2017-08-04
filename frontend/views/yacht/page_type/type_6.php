<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\models\CrewMemberRole;
use common\models\Yacht;

?>
<?php
$form = ActiveForm::begin([
//        'action' => '/yacht/create',
        'options' => ['enctype' => 'multipart/form-data'],
        'validateOnSubmit' => false,
    ]);

?>
<!-- rec page -->
<div class="header-map large"></div>

<section class="container create-pin">
    <p class="wave-title">
             <?= Yii::t('yacht', 'Create Profile for a BAR BOAT') ?>
    </p>

    <h2 class="h2-title">
           <?= Yii::t('yacht', 'Please fill in the following information') ?>
    </h2>


    <div class="row">
        <div class="container">
            <div class="row">

                <div class="col-lg-7">
                    <div class="page-preview blue">
                        <div class="head"></div>


                        <div class="col-md-12">
                            <div class="row edit-location first">
                                <div class="form-group">
                                    <?= $form->field($model, 'name')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Yacht Name*')])->label(false) ?>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="row edit-location">
                                <div class="form-group">
                                    <div class="select js-yacht-select-type">

                                        <?= $form->field($model, 'yacht_type_id')->dropDownList(Yacht::itemAlias('type_yacht'), ['class' => ''])->label(false) ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row edit-location">
                                <div class="form-group">
                                    <div class="select js-yacht-select-type">

                                        <?= $form->field($model, 'yacht_type_two_id')->dropDownList(Yacht::itemAlias('type_yacht_two'), ['class' => ''])->label(false) ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 js-yacht-type" style="<?php echo ($model->yacht_type_id != Yacht::TYPE_OTHER) ? 'display: none;' : '' ?>">
                            <div class="row edit-location">
                                <div class="form-group">


                                    <?= $form->field($model, 'yacht_type')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Other type*')])->label(false) ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row edit-location">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model, 'year')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Year')])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model, 'yacht_build')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Yacht Build')])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row edit-location">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model, 'home_port')->textInput(['class' => '', 'id' => "js-google-autocomplete", 'placeholder' => \Yii::t('yacht', 'Home Port')])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model, 'length')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Length')])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row edit-location">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model, 'beam')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Beam')])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model, 'draft')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Draft')])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row edit-location">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model, 'air_draft')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Air Draft')])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model, 'website')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Website')])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row edit-location">
                                <div class="form-group">
                                    <?= $form->field($model, 'charter_company')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Charter Company')])->label(false) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row edit-location">
                                <div class="form-group">
                                    <?= $form->field($model, 'contact_info')->textInput(['class' => '', 'placeholder' => \Yii::t('yacht', 'Charter Broker Name & Contact info')])->label(false) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row edit-location radio">
                                <div class="form-group">
                                    <div class="radio">
                                        <div class="lavbel-semulation"> 


                                            <?= Html::activeCheckbox($model, 'share', ['class' => '', 'value' => Yacht::SHARE_TRUE, 'label' => false]) ?>
                                            <?= Yii::t('yacht', 'Yes, I would like to share my vessel details in reviews to help give context to other boaters.') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row edit-location radio">
                                <div class="form-group">
                                    <div class="radio">
                                        <div class="lavbel-semulation"> 
                                            <?= Html::activeCheckbox($model, 'charter_button', ['class' => '', 'value' => Yacht::CHARTET_BUTTON_TRUE, 'label' => false]) ?>
                                            <?= Yii::t('yacht', ' Display "Inquire about Charter" button on profile') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>


                <?php
                echo $this->render('//yacht/page_type/photo_block', [
                    'model' => $model,
                    'image' => $image,
                    'form' => $form,
                ]);

                ?>

            </div>
        </div>
    </div>

</section>



<?php
echo $this->render('//yacht/page_type/blog_enable', [
    'model' => $model,

]);

?>

<div class="container margin-bottom-50">
    <div class="row">
                <div class="col-md-4 col-md-offset-4 text-center ">
                    <?= Html::submitButton(empty($model->id) ? 'Save' : 'Update', [ 'class' => "red-btn"]) ?>
                </div>
            </div>
</div>

<?= Html::hiddenInput('subtype_id', $subtype_id) ?>
<!-- END rec PAGE -->

<?php ActiveForm::end(); ?>
<?php
echo $this->render('//yacht/page_type/blog', [
    'model' => $model,
    'form' => $form,
    'modelBlogPost' => $modelBlogPost,
    'modelBlogPostImage' => $modelBlogPostImage,
    'searchModelBlogPost' => $searchModelBlogPost,
    'dataProviderBlogPost' => $dataProviderBlogPost,
]);

?>
<?php
echo $this->render('//yacht/page_type/script', [
    'model' => $model,
    'form' => $form,
]);

?>