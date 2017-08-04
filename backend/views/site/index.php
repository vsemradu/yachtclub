<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Dashboard';

?>

<!-- Main content -->
<section class="content">

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?= $modelBlogPostCount ?>
                    </h3>
                    <p>
                        <?= \Yii::t('admin', 'Blog'); ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>


                <?= Html::a(' More info <i class="fa fa-arrow-circle-right"></i>', ['/blog-post/index'], ['class' => 'small-box-footer']) ?>

            </div>
        </div>



        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?= $modelReviewsCount ?>
                    </h3>
                    <p>
                        <?= \Yii::t('admin', 'Review'); ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>


                <?= Html::a(' More info <i class="fa fa-arrow-circle-right"></i>', ['/reviews/index-business'], ['class' => 'small-box-footer']) ?>

            </div>
        </div>



        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?= $modelUserPinCount ?>
                    </h3>
                    <p>
                        <?= \Yii::t('admin', 'Pin'); ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <?= Html::a(' More info <i class="fa fa-arrow-circle-right"></i>', ['/user-pin/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div><!-- ./col -->



        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?= $modelLocalInfoCount ?>
                    </h3>
                    <p>
                        <?= \Yii::t('admin', 'Local page'); ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <?= Html::a(' More info <i class="fa fa-arrow-circle-right"></i>', ['/local-info/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->

</section>
