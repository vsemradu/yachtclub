<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Busines;

$business_id = Yii::$app->session->getFlash('business_id');

?>
<!-- rec page -->
<div class="header-map large"></div>
<?php $form = ActiveForm::begin(['action' => '/busines/type-step-two']); ?>
<section class="container create-pin">
    <p class="wave-title">
        <?= \Yii::t('business', 'Create Profile for a Business'); ?>
    </p>

    <h2 class="h2-title">
        <?= \Yii::t('business', ' What kind of Business is this?'); ?>
    </h2>

    <?php $style_key = 1; ?>
    <?php foreach (Busines::itemAlias('type_title') as $key => $type_title) { ?>


        <?php if ($style_key == 1) { ?>
            <div class="row radio-list">
            <?php } ?>

            <div class="col-md-3 col-sm-6">
                <div class="radio">

                    <?php if ($key == Busines::TYPE_OTHER) { ?>

                        <label>
                            <?= Html::radio('type_id', ($type_id == $key) ? true : false, ['class' => 'js-type-radio', 'value' => $key, 'uncheck' => null]) ?>
                            <?= Html::textInput('type_text', !empty($type_text) ? $type_text : '', ['class' => 'js-otheer-text form-control', 'placeholder' => 'Other']) ?>
                        </label>

                    <?php } else { ?>
                        <label>
                            <?= Html::radio('type_id', ($type_id == $key) ? true : false, ['class' => 'js-type-radio', 'value' => $key, 'uncheck' => null]) ?>
                            <?= Html::img("../img/create_icons/" . $key . ".png") ?>
                            <?= $type_title ?>
                        </label>
                    <?php } ?>


                </div>
            </div>

            <?php if ($style_key == 4) { ?>
            </div>
        <?php } ?>

        <?php $style_key++; ?>


        <?php if ($style_key == 5) { ?>
            <?php $style_key = 1; ?>
        <?php } ?>

    <?php } ?>

</section>

<section class="container-fluid blue-block-btns js-business-block" style="<?php echo empty($type_id) ? 'display: none;' : '' ?>">
    <div class="row">
        <div class="container">
            <p class="title">
                <?= \Yii::t('business', 'Do you own or manage this business?'); ?>
            </p>

            <div class="row">
                <div class="col-md-2 col-md-offset-4">


                    <button data-type="yes" type="submit" name="owner" value="<?= Busines::OWN_TRUE ?>" class="js-success red-btn"> <?= \Yii::t('business', 'YES'); ?></button>

                </div>
                <div class="col-md-2">

                    <button data-type="no" type="submit" name="owner" value="<?= Busines::OWN_FALSE ?>" class="js-success blue-btn"> <?= \Yii::t('business', 'NO'); ?></button>

                </div>
            </div>
        </div>
    </div>
</section>


<?php ActiveForm::end(); ?>
<!-- END rec PAGE -->

<?php if ($business_id) { ?>
    <div class="modal" id="buisinessCreateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">      <?= \Yii::t('business', 'Finished!'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="text">
                        <p class="red">
                            <?= \Yii::t('business', 'Thank you for creating your business page!'); ?>
                        </p>
                        <p>
                            <?= \Yii::t('business', 'Now'); ?> <a href="/busines/view?id=<?= $business_id ?>"><?= \Yii::t('business', 'share it'); ?></a> <?= \Yii::t('business', 'to get your first review!'); ?> 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    $(function () {
<?php if ($business_id) { ?>

            $('#buisinessCreateModal').modal('show');
<?php } ?>
        $('input.js-type-radio').change(function () {

            $('.js-business-block').fadeIn();
            $.scrollTo('.js-business-block', 1000);
        });


        $('.js-success').click(function (event) {

            if ($('input.js-type-radio:checked').val() == <?= Busines::TYPE_OTHER ?>) {


                var StrippedString = $('.js-otheer-text').val().replace(/(<([^>]+)>)/ig, "");
                $('.js-otheer-text').val(StrippedString);
                $('.js-otheer-text').val($.trim($('.js-otheer-text').val()));

                if ($('.js-otheer-text').val() == '') {
                    alert('Please enter type name.');
                    event.preventDefault();
                }
            }
            if ($(this).data('type') == 'no') {
                form = $(this).parents('form');
                $(form).attr('action', '/busines/type-step-three');
//                console.log($(form));
//                event.preventDefault();
            }
        });
    });


</script>