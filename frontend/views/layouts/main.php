<?php
use kartik\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use frontend\models\PinModalForm;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=geometry,places&language=en"></script>
        <script src="https://googlemaps.github.io/js-rich-marker/src/richmarker.js"></script>



        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>




    </head>
    <body onload="initializeAutoCompleate()">
        <?php $this->beginBody() ?>

        <div id="loadingmessage" style="display: none;">
            <div id="loader"></div>
        </div>

        <div class="js-right-corner right-corner" style="display: none;">
            <a href="#" id="js-cancel-drop-pin" class="blue-btn on-map"><?= \Yii::t('home', 'Cancel drop PIN'); ?></a>
        </div>


        <?php
        Modal::begin([
            'header' => '<h4 class="modal-title">Drop pin</h4>',
            'toggleButton' => false,
            'id' => 'js-alert-pin-modal',
            'footer' => '<button type="button" class="btn btn-default js-pin-send">Ok</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        echo '<div class="js-content-modal"></div>';
        Modal::end();

        Modal::begin([
            'header' => '<h4 class="modal-title">Search results</h4>',
            'toggleButton' => false,
            'id' => 'js-search-modal', 
//            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        echo '<div class="js-content-modal"></div>';
        Modal::end();

        ?>



        <nav class="container-fluid head-menu">
            <div class="row">

                <a href="<?= Url::toRoute('/site/index'); ?>" class="logo">
                    <img src="<?php
                    echo Url::toRoute('/img/logo.png');

                    ?>" alt="">
                </a>

                <i class="ion-navicon open-menu"></i>

                <div class="left-collapse">
                    <ul>
                        <li>
                            <form class="js-form-search">
                                <input type="text" id="js-google-autocomplete-header" class="search js-search" placeholder="Search">
                                <i class="js-search-icon ion-ios-search-strong"></i>
                            </form>
                        </li>
<?php if (!Yii::$app->user->isGuest) { ?>
                            <li>
                                <div class="head-dropdown">
                                    <?php if (!empty(Yii::$app->user->identity->userInfo->imageUrl)) { ?>
                                        <div class="photo" style="background:url(<?= Yii::$app->user->identity->userInfo->imageUrl ?>)no-repeat center;background-size:cover;"></div>
                                    <?php } else { ?>
                                        <div class="photo"></div>
    <?php } ?>

                                    <div class="name">
    <?= Yii::$app->user->identity->userInfo->first_name ?><br><?= Yii::$app->user->identity->userInfo->last_name ?>
                                    </div>
                                    <i class="fa fa-caret-down"></i>
                                </div>

                                <?=
                                \yii\widgets\Menu::widget([
                                    'items' => [
                                        // Important: you need to specify url as 'controller/action',
                                        // not just as 'controller' even if default action is used.
                                        ['label' => \Yii::t('profile', 'My Pages'), 'url' => ['profile/index']],
                                        ['label' => \Yii::t('profile', 'My Pins'), 'url' => ['profile/pins']],
                                        ['label' => \Yii::t('profile', 'My Reviews'), 'url' => ['profile/reviews']],
                                    ],
                                    'options' => ['class' => 'head-drop-down-open'],
                                ]);

                                ?>

                            </li>

                            <li>
                                <a href="<?= Url::toRoute('/profile/edit') ?>" class="nav-login-btn">
                                    <i class="fa fa-pencil"></i>
    <?= \Yii::t('menu', 'Edit'); ?>
                                </a>
                            </li>

                            <li>
                                <a href="<?= Url::toRoute('/site/logout') ?>" class="nav-login-btn red">
                                    <i class="fa fa-power-off"></i>
    <?= \Yii::t('menu', 'Logout'); ?>
                                </a>
                            </li>

<?php } else { ?>
                            <li>
                                <a href="#" class="sign-in-btn" data-toggle="modal" data-target="#loginModal"> <?= \Yii::t('menu', 'LOG IN'); ?></a>
                            </li>
                            <li>
                                <a href="#" class="sign-up-btn" data-toggle="modal" data-target="#registrationModal"> <?= \Yii::t('menu', 'SIGN UP'); ?></a>
                            </li>
<?php } ?>
                    </ul>
                </div>
            </div>
        </nav>




        <?php if (Yii::$app->session->hasFlash('success')) { ?>

            <?php
            echo kartik\growl\Growl::widget([
                'type' => kartik\growl\Growl::TYPE_SUCCESS,
                'title' => Yii::t('success_message', 'Thank you!'),
                'icon' => 'glyphicon glyphicon-ok-sign',
                'body' => Yii::$app->session->getFlash('success'),
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'bottom',
                        'align' => 'right',
                    ],
                    'delay' => 10000,
                ],
            ]);

            ?>
        <?php } ?>
        <?php if (Yii::$app->session->hasFlash('error')) { ?>

            <?php
            echo kartik\growl\Growl::widget([
                'type' => kartik\growl\Growl::TYPE_WARNING,
                'title' => Yii::t('success_message', 'Error!'),
                'icon' => 'glyphicon glyphicon-ok-sign',
                'body' => Yii::$app->session->getFlash('error'),
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'bottom',
                        'align' => 'right',
                    ],
                    'delay' => 10000,
                ],
            ]);

            ?>
        <?php } ?>

<?= $content ?>


        <footer class="container-fluid">
            <div class="row">
                <div class="container">
                    <a href="<?= Url::toRoute('/site/index'); ?>" class="logo">
                        <img src="<?php
                        echo Url::toRoute('/img/logo.png');

                        ?>" alt="footer logo">
                    </a>

                    <div class="soc-footer">
                        <a href="https://www.facebook.com/yachtcrewadvisor">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="https://instagram.com/yachtadvisor/">
                            <i class="fa fa-instagram"></i>
                        </a>

                        <a href="https://twitter.com/yachtsadvisor">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>


        <!-- LOGIN -->
<?php echo $this->render('modal_login', ['model' => new \common\models\LoginForm()]); ?>
        <!-- LOGIN -->

        <!-- REGISTRATION -->
<?php echo $this->render('modal_registration', [ 'model' => new \common\models\User(), 'modelInfo' => new \common\models\UserInfo()]); ?>
        <!-- REGISTRATION -->


        <script type="text/javascript">
            function statusChangeCallback(response) {
                if (response.status === 'connected') {
                    getFbLogin();
                }
            }

            function getFbLogin() {
                FB.api('/me?fields=id,first_name,last_name,email', function (response) {
                    $.post('/site/ajax-fb-signup', response)
                            .done(function (data) {

                                window.location.replace("<?= Url::toRoute('profile/edit'); ?>");
                            });
                });



            }


            function checkLoginState() {
                FB.init({appId: '<?php echo Yii::$app->params['fBappId']; ?>',
                    cookie: false, xfbml: true,
                    version: 'v2.4'
                });

                FB.login(function () {
                    FB.getLoginStatus(function (response) {
                        statusChangeCallback(response);
                    });
                }, {scope: 'email,public_profile, user_photos'});
            }


            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));


        </script>

<?php $this->endBody() ?>
        <script src="//cdn.jsdelivr.net/jquery.scrollto/2.1.0/jquery.scrollTo.min.js"></script>



        <?php
        Modal::begin([
            'header' => '<h4 class="modal-title">Pin</h4>',
            'toggleButton' => false,
            'id' => 'js-pin-modal'
        ]);
        $modelPinModalForm = new PinModalForm();

        ?>

        <h3 class="text-center"><?= \Yii::t('pin', 'Enter GPS coordinates manually'); ?></h3>
        <br>

        <?php
        $form = ActiveForm::begin([
                'action' => ['profile/create-pin'],
                'method' => 'get',
        ]);

        ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?= $form->field($modelPinModalForm, 'lat', ['template' => '{label}<p>Format: 4.375573405364947</p>{input}{hint}{error}'])->textInput() ?>
<?= $form->field($modelPinModalForm, 'lan', ['template' => '{label}<p>Format: -68.85599613189697</p>{input}{hint}{error}'])->textInput() ?>
            </div>
        </div>
        <br> 
        <div class="text-center">
<?= Html::submitButton('Next', ['class' => "blue-btn"]) ?>
        </div>

<?php ActiveForm::end(); ?>

        <br> 
        <div class="text-center">
<?= \Yii::t('pin', 'OR'); ?>
        </div>
        <h3 class="text-center">
<?= \Yii::t('pin', 'Find the location on the map'); ?>
        </h3>



        <div class="text-center">
<?= Html::button('Find', ['id' => 'js-pin-find-map', 'class' => "blue-btn"]) ?>
        </div>




<?php Modal::end(); ?>
    </body>
</html>
<?php $this->endPage() ?>
