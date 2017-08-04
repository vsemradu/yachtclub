<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\BusinessHappyHour;



?>
<div class="row">
        <div class="page-preview">
            <div class="head">
                <?= \Yii::t('business', 'Happy Hours'); ?>
            </div>
            <br>
            <div class="js-happy-hours-form">

                <?php
                foreach ($happyHours as $happyHour) {
                    echo $this->render('//busines/_ajax_happy_hour', [
                        'business' => $business,
                        'model' => $happyHour,
                        'remove' => true,
                    ]);
                }

                ?>
            </div>




            <div class="text-center">
                <a href="#" class="js-add-happy-hours blue-btn lg">
                    <?= \Yii::t('business', '+ Add Happy Hours') ?>
                </a>
            </div>

        </div>
    </div>