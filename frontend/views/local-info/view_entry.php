<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\LocalInfo */

$this->title = $model->area_name;

?>


<?=
$this->render('_map', [
    'model' => $model,
]);

?>

<br>

<?=
$this->render('_menu', [
    'model' => $model,
]);

?>
<div class="fixed-right-sidebar" style="display: none;"> 

    <?php if (!empty($businesList)) { ?>
        <a onclick="$.scrollTo('.js-port-of-entry', 500);" href="javascript:;"><?= \Yii::t('localInfo', 'Port of Entry'); ?></a><br>
    <?php } ?>
    <a onclick="$.scrollTo('.js-customs-immigration', 500);" href="javascript:;"><?= \Yii::t('localInfo', 'Customs & Immigration'); ?></a><br>
    <a onclick="$.scrollTo('.js-marine-laws-regulations', 500);" href="javascript:;"><?= \Yii::t('localInfo', 'Marine Laws & Regulations'); ?></a><br>
</div>
<?php if (!empty($businesList)) { ?>
    <section class="container-fluid local-port js-port-of-entry">
        <div class="row">
            <div class="container">
                <p class="title">
                    <?= \Yii::t('localInfo', 'Port of Entry'); ?>
                </p>
                <?php foreach ($businesList as $k => $busines) { ?>
                    <div class="col-md-2 col-md-offset-2">
                        <a target="_blank" href="/busines/view?id=<?= $k ?>"><?= $busines ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<section class="container local-white-block js-customs-immigration">
    <p class="title">
        <?= \Yii::t('localInfo', 'Customs & Immigration'); ?>
    </p>
    <div class="text js-text-localInfo js-text-customs-immigrations">

        <span class="js-little"> </span>
        <span class="js-big" style="display: none;">
            <?= $model->customs_immigrations ?> <a class="js-read-less" href="#"> <?= \Yii::t('localInfo', 'Read less'); ?></a>
        </span>
    </div>



</section>

<section class="container-fluid blue-section-second second  js-marine-laws-regulations">
    <div class="row">
        <div class="container">
            <p class="title">
                <?= \Yii::t('localInfo', 'Marine Laws & Regulations'); ?>
            </p>

            <div class="local-text js-text-localInfo js-text-marine-laws-regulations">

                <span class="js-little"></span>
                <span class="js-big" style="display: none;">
                    <?= $model->marine_laws_regulations ?><a class="js-read-less" href="#"><?= \Yii::t('localInfo', 'Read less'); ?></a>
                </span>


            </div>
        </div>
    </div>
</section>




<section class="container reviews-block">

    <?php if (Yii::$app->user->id) { ?>
        <a href="#" class="add-review-btn js-add-comment">
            <?= \Yii::t('localInfo', '+ Add Comments'); ?>
        </a>

        <div class="js-add-comment-block container add-reviews" style="<?php echo!empty($localInfoComment->user_id) ? '' : 'display: none;'; ?>">

            <?php
            $form = ActiveForm::begin([
                    'validateOnSubmit' => true,
            ]);

            ?>
            <div class="form-group">
                <?= $form->field($localInfoComment, 'text')->textarea(['rows' => "5", 'class' => 'form-control input-lg', 'placeholder' => 'Comment'])->label(false) ?>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="blue-btn"><?= \Yii::t('localInfo', 'Submit'); ?></button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php } ?>


    <?php if (!empty($dataProviderLocalInfoComment->totalCount)) { ?>
        <div class="comments">
            <p class="title">
                <?= \Yii::t('localInfo', 'COMMENTS'); ?>
            <sm>
                <?= $dataProviderLocalInfoComment->totalCount ?>   <?= \Yii::t('localInfo', 'comments'); ?></sm>
            </p>
        </div>
        <div class="blog-post-comments">
            <?php \yii\widgets\Pjax::begin(['id' => 'localInfo-comments']); ?>
            <?=
            yii\widgets\ListView::widget([
                'dataProvider' => $dataProviderLocalInfoComment,
                'itemView' => '_localInfo_view_comments',
                'layout' => "{items}\n{pager}",
            ]);

            ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    <?php } ?>

</section>

<script type="text/javascript">
    $(function () {
        $('.js-add-comment').click(function (event) {
            $('.js-add-comment-block').show();
            event.preventDefault();
        });




        $(document).on('click', ".js-delete-comment-localInfo", function (event) {
            block = $(this);
            $.get($(block).attr('href')).done(function (data) {
                if (data == 'true') {
                    $(block).parents('.comment').remove();
                    alert('Comment has been deleted');
                    $.pjax.reload({container: "#localInfo-comments"});
                }
            });
            event.preventDefault();
        });




        var customs_immigrations = <?= $model->customsImmigrationsJson ?>;
        var customs_immigrations = htmlTexttruncate(customs_immigrations.data);
        $('.js-text-customs-immigrations span.js-little').html(customs_immigrations);

        var marine_laws_regulations = <?= $model->marineLawsRegulationsJson ?>;
        var marine_laws_regulations = htmlTexttruncate(marine_laws_regulations.data);
        $('.js-text-marine-laws-regulations span.js-little').html(marine_laws_regulations);

    });
</script>