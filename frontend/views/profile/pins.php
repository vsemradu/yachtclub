<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\UserPin;

?>
<!-- PROFILE page -->

<section class="container-fluid profile-page">
    <div class="row">
        <div class="container">

            <?= $this->render('header_profile'); ?>


            <div class="profile-tabs-content">
                <div class="row">
                    <div class="col-md-5">
                        <div class="page-preview">
                            <div class="head">

                            </div>

                            <ul class="page-preview-pins">

                                <?php if (!empty($pinsList)) { ?>
                                    <?php foreach ($pinsList as $type => $pin) { ?>
                                        <li>
                                            <span class="icon">
                                                <img src="../img/pin_icons/<?= $type ?>.png" alt="">
                                            </span>
                                            <?= UserPin::itemAlias('type_name', $type) ?>
                                            <span class="pins">
                                                <?php echo count($pin); ?> pins <i class="fa fa-caret-down"></i>
                                            </span>

                                            <ul class="pins-dropdown">
                                                <?php foreach ($pin as $p) { ?>
                                                    <li class="clearfix">
                                                        <a href="<?= Url::toRoute(['/pin/view', 'id' => $p->id]) ?>"><?= $p->pinField->name ?></a>
                                                        <?php if ($p->approved == UserPin::APPROVED_TRUE) { ?>
                                                            <span style="color: #00AA88"><?= \Yii::t('pins', 'Approved'); ?></span>
                                                        <?php } else { ?>
                                                            <span style="color: #e9322d"><?= \Yii::t('pins', 'Waiting for Approval'); ?></span>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>

                                                <li>

                                            </ul>
                                        </li>
                                    <?php } ?>
                                <?php } else { ?>
                                        <li>You haven't created any pin yet</li>
                                <?php } ?>
                            </ul>

                        </div>

                        <div class="create-new-page">
                            <a href="#" id="js-drop-pin" class="btn-create"><i class="ion-ios-plus-empty"></i><?= \Yii::t('pins', 'Create new pin'); ?></a>
                        </div>


                    </div>

                    <script>
                        var pins = <?= !empty($pins) ? $pins : '""' ?>;
                        var apiGoogleKey = '<?= Yii::$app->params['apiGoogleKey'] ?>';
                    </script>
                    <script src="/js/google_map.js"></script>
                    <div class="col-md-7">
                        <div class="pin-map">
                            <div style="width: 100%; height: 100%; position: absolute;" class="map-canvas off" id="js-map-canvas"></div>

                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</section>

<!-- END PROFILE PAGE -->
