<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Busines;

?>
<!-- rec page -->
<div class="header-map large"></div>
<?php $form = ActiveForm::begin(['action' => '/busines/type-step-three']); ?>


<?= Html::hiddenInput('type_text', $type_text) ?>
<?= Html::hiddenInput('owner', $owner) ?>
<?= Html::hiddenInput('type_id', $type_id) ?>
<section class="container create-pin">
    <p class="wave-title">
        <?= \Yii::t('business', 'Create Profile for a Business'); ?>
    </p>


    <div class="row bordered-qw">
        <div class="col-md-6 bordered-qw-item first">
            <div class="bordered-qw-wrap">
                <h2 class="h2-title">
                    <?= \Yii::t('business', 'What type of Business is this?'); ?>
                </h2>
                <div class="radio">
                    <label>

                        <?php if ($type_id == Busines::TYPE_OTHER) { ?>
                            <input type="radio" name="optionsRadios" checked="">
                            <?= $type_text ?>
                        <?php } else { ?>
                            <input type="radio" name="optionsRadios" checked="">
                            <img src="../img/create_icons/<?= $type_id ?>.png" alt="">
                            <?= Busines::itemAlias('type_title', $type_id) ?>
                        <?php } ?>


                        <a href="/busines/type?type_id=<?= $type_id ?>&owner=<?= $owner ?>&type_text=<?= $type_text ?>" class="edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-6 bordered-qw-item">
            <div class="bordered-qw-wrap">
                <h2 class="h2-title">
                    <?= \Yii::t('business', 'Do you own or manage this business?'); ?>
                </h2>
                <div class="no-qw">
                    <label>

                        <?php if ($owner == Busines::OWN_TRUE) { ?>
                            <?= \Yii::t('business', 'YES'); ?>
                        <?php } else { ?>
                            <?= \Yii::t('business', 'NO'); ?>
                        <?php } ?>
                        <a href="/busines/type?type_id=<?= $type_id ?>&owner=<?= $owner ?>&type_text=<?= $type_text ?>" class="edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </label>
                </div>
            </div>
        </div>
    </div>


</section>

<section class="container-fluid blue-block-btns">
    <div class="row">
        <div class="container">
      
                <p class="title">
                    <?= \Yii::t('business', 'Would you like this business page to be publicly linked to your profile?'); ?>
                </p>


            <div class="row">
                <div class="col-md-2 col-md-offset-4">

                    <button type="submit" name="private" value="<?= Busines::PRIVATE_TRUE ?>" class="red-btn"> <?= \Yii::t('business', 'YES'); ?></button>
                </div>
                <div class="col-md-2">

                    <button type="submit" name="private" value="<?= Busines::PRIVATE_FALSE ?>" class="blue-btn"> <?= \Yii::t('business', 'NO'); ?></button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php ActiveForm::end(); ?>

<!-- END rec PAGE -->