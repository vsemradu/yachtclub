<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\models\UserPin;
use common\models\Reviews;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$userPinNotAprroved = UserPin::find()->where(['approved' => UserPin::APPROVED_WAITING])->all();
$reviewNotAprroved = Reviews::find()->where(['approved' => Reviews::APPROVED_WAITING])->all();

?>

<header class="header">

    <?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-right">

            <ul class="nav navbar-nav">

                <?php if (!empty(count($userPinNotAprroved))) { ?>
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-tasks"></i>
                            <span class="label label-danger"><?= count($userPinNotAprroved) ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?= \Yii::t('admin', 'You have {count} new Pins', ['count' => count($userPinNotAprroved)]); ?></li>
                            <li>
                                <ul class="menu">
                                    <?php foreach ($userPinNotAprroved as $userPin) { ?>
                                        <li><!-- Task item -->


                                            <?= Html::a('<h3>' . $userPin->pinFieldName . '</h3>', ['/user-pin/update', 'id' => $userPin->id]) ?>

                                        </li>
                                    <?php } ?>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">

                                <?= Html::a(\Yii::t('admin', 'View Pins'), ['/user-pin/index']) ?>
                               
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (!empty(count($reviewNotAprroved))) { ?>
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-tasks"></i>
                            <span class="label label-danger"><?= count($reviewNotAprroved) ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?= \Yii::t('admin', 'You have {count} new Review', ['count' => count($reviewNotAprroved)]); ?></li>
                            <li>
                                <ul class="menu">
                                    <?php foreach ($reviewNotAprroved as $review) { ?>
                                        <li><!-- Task item -->


                                            <?= Html::a('<h3>' . $review->littleText . '</h3>', ['/reviews/update', 'id' => $userPin->id]) ?>

                                        </li>
                                    <?php } ?>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">

                                <?= Html::a(\Yii::t('admin', 'View Reviews'), ['/reviews/index-business']) ?>
                               
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php
                if (Yii::$app->user->isGuest) {

                    ?>
                    <li class="footer">
                        <?= Html::a('Login', ['/site/login']) ?>
                    </li>
                    <?php
                } else {

                    ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?= @Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">


                                <?php if (!empty(@Yii::$app->user->identity->userInfo->imageUrl)) { ?>

                                    <img src="<?= @Yii::$app->user->identity->userInfo->imageUrl ?>" class="img-circle" alt="User Image"/>
                                <?php } else { ?>
                                    <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle" alt="User Image"/>
                                <?php } ?>


                                <p>
                                    <?= @Yii::$app->user->identity->userInfo->fullName ?>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">


                                    <?=
                                    Html::a(
                                        'Profile', ['../profile/edit'], ['class' => 'btn btn-default btn-flat']
                                    )

                                    ?>

                                </div>
                                <div class="pull-right">
                                    <?=
                                    Html::a(
                                        'Sign out', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                    )

                                    ?>
                                </div>
                            </li>
                        </ul>
                    </li><?php
                }

                ?>
                <!-- User Account: style can be found in dropdown.less -->

            </ul>
        </div>
    </nav>
</header>
