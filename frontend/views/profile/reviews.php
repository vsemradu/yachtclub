<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<!-- PROFILE page -->

<section class="container-fluid profile-page">
    <div class="row">
        <div class="container">

            <?= $this->render('header_profile'); ?>


            <div class="profile-tabs-content">
                <div class="row">

                    <?=
                    yii\widgets\ListView::widget([
                        'dataProvider' => $dataProviderReviews,
                        'itemView' => '_review',
                        'layout' => "{pager}\n{items}\n{pager}",
                        'emptyText' => '<h3>You haven\'t left any review yet</h3>'
                    ]);

                    ?>
                    


                </div>
            </div>

        </div>
    </div>
</section>

<!-- END PROFILE PAGE -->