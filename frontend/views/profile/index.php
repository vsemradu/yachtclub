<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Yacht;
use yii\widgets\ActiveForm;

?>

<section class="container-fluid profile-page">
    <div class="row">
        <div class="container">

            <?= $this->render('header_profile'); ?>

            <div class="profile-tabs-content">
                <div class="row">
                    <div class="col-md-5">

                        <div class="create-new-page">
                            <a href="javascript:;" onclick="javascript:$('#businessModal').modal('show');" class="btn-create"><i class="ion-ios-plus-empty"></i>Create new page</a>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="table-responsive">
                            <?php if (empty($userPages)) { ?>
                            <h3>You haven't created any page yet</h3>
                            <?php } ?>
                            
                            <?php if (!empty($userPages)) { ?>

                                <table class="table">
                                    <thead>
                                    <th>Name</th>
                                    <th>Created</th>
                               
                                    <th></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($userPages as $userPage) { ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php
                                                    if ($userPage['type'] == 'yacht') {
                                                        echo '/yacht/view?id=' . $userPage['data']->id;
                                                    } else {
                                                        echo '/busines/view?id=' . $userPage['data']->id;
                                                    }

                                                    ?>">
                                                           <?php
                                                           if ($userPage['type'] == 'yacht') {
                                                               echo $userPage['data']->name;
                                                           } else {
                                                               echo $userPage['data']->business_name;
                                                           }

                                                           ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?= date('M d, Y', $userPage['data']->date_create); ?>
                                                </td>

                                                <td>
                                                    <a href="
                                                    <?php
                                                    if ($userPage['type'] == 'yacht') {
                                                        echo '/yacht/update?id=' . $userPage['data']->id;
                                                    } else {
                                                        echo '/busines/update?id=' . $userPage['data']->id;
                                                    }

                                                    ?>
                                                       ">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>




<div class="modal fade" id="businessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= \Yii::t('home', 'Create Page'); ?></h4>
            </div>
            <div class="modal-body">


                <div class="text">
                    <p>
                        <?= \Yii::t('home', 'Select what type of page you want to create'); ?>
                    </p>
                </div>
                <ul class="pins-list">
                    <li class="js-yacht"><span class="ico"><img src="../img/create_icons/popicon_1.png" alt=""> </span><?= \Yii::t('home', 'Create Profile for a Vessel'); ?></li>
                    <li><a href="/busines/type"><span class="ico"><img src="../img/create_icons/popicon_2.png" alt=""> </span><?= \Yii::t('home', 'Create Profile for a Business'); ?></a></li>
                </ul>




                <div class="footer-btn center-btns">
                    <a href="javascript:;" onclick="javascript:$('#businessModal').modal('hide');" class="blue-btn"><?= \Yii::t('home', 'Cancel'); ?></a>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="yachtModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= \Yii::t('home', 'Create Yacht Page'); ?></h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['action' => '/yacht/create']); ?>
                <div class="js-yacht-select-type-block">
                    <p class="modal-p">
                        <?= \Yii::t('home', 'Is this a'); ?>
                    </p>
                    <ul class="pins-list">
                        <li daya-id="<?= Yacht::TYPE_CHARTER ?>" class="js-yacht-charter"><span class="ico "><img src="../img/create_icons/cahrter_icon.png" alt=""> </span><?= \Yii::t('home', 'Charter Vessel'); ?></li>
                        <li daya-id="<?= Yacht::TYPE_PRIVATE ?>" class="js-yacht-private"><span class="ico "><img src="../img/create_icons/private_icon.png" alt=""> </span><?= \Yii::t('home', 'Private Vessel'); ?></li>
                    </ul>

                    <ul class="js-yacht-type-charter ul-checkboxes" style="display: none;">
                        <li><span class="js-yacht-type"><?= Html::radio('subtype_id', false, ['class' => '', 'value' => Yacht::TYPE_CHARTER_CREWED, 'uncheck' => null]) ?></span> <?= \Yii::t('home', 'Crewed Boat'); ?></li>
                        <li><span class="js-yacht-type"><?= Html::radio('subtype_id', false, ['class' => '', 'value' => Yacht::TYPE_CHARTER_BARE, 'uncheck' => null]) ?></span> <?= \Yii::t('home', 'Bare Boat'); ?></li>
                    </ul>

                    <ul class="js-yacht-type-private ul-checkboxes"  style="display: none;">
                        <li><span class="js-yacht-type"><?= Html::radio('subtype_id', false, ['class' => '', 'value' => Yacht::TYPE_PRIVATE_CREWED, 'uncheck' => null]) ?></span> <?= \Yii::t('home', 'Crewed Boat'); ?></li>
                        <li><span class="js-yacht-type"><?= Html::radio('subtype_id', false, ['class' => '', 'value' => Yacht::TYPE_PRIVATE_OWNER, 'uncheck' => null]) ?></span> <?= \Yii::t('home', 'Owner Operated Boat'); ?></li>
                    </ul>
                </div>


                <div class="footer-btn js-page-create center-btns" style="display: none;">
                    <button  type="submit" class="blue-btn"> <?= \Yii::t('home', 'Create'); ?></button>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        $('.js-yacht').click(function (event) {
            $('#businessModal').modal('hide');
            $('#yachtModal').modal('show');

        });
        $('.js-yacht-charter').click(function (event) {
            $('.js-yacht-type-private').hide(300);
            $('.js-yacht-type-charter').show(300);

        });
        $('.js-yacht-private').click(function (event) {
            $('.js-yacht-type-charter').hide(300);
    $('.js-yacht-type-private').show(300);

        });
        $('.js-yacht-type').click(function (event) {
            $('.js-page-create').show(300);
        });
    });


</script>
<!-- END PROFILE PAGE -->