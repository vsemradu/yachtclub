<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
if (Yii::$app->controller->action->id === 'login') {
    //TODO: Override layout for login action instead of if..else
    echo $this->render(
        'wrapper-black', ['content' => $content]
    );
} else {
    dmstr\web\AdminLteAsset::register($this);
    backend\assets\AppAsset::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower') . '/admin-lte';

    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=geometry,places&language=en"></script>
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode(Yii::$app->name) ?></title>
            <?php $this->head() ?>

            <style>
                /* TODO: Move to styles instead. */
                /* To rectify google map controls distorts issue */
                .gmnoprint img{
                    max-width:none !important;
                }

            </style>
        </head>
        <body class="skin-blue">
            <?php $this->beginBody() ?>
            <?php if (Yii::$app->session->hasFlash('success_admin')) { ?>

                <?php
                echo kartik\growl\Growl::widget([
                    'type' => kartik\growl\Growl::TYPE_SUCCESS,
                    'title' => Yii::t('success_message', 'Well done!'),
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'body' => Yii::$app->session->getFlash('success_admin'),
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
            <?=
            $this->render(
                'header.php', ['directoryAsset' => $directoryAsset]
            )

            ?>

            <div class="wrapper row-offcanvas row-offcanvas-left">
                <?php //TODO: use left, content instead of direct files .php ?>
                <?=
                $this->render(
                    'left.php', ['directoryAsset' => $directoryAsset]
                )
                ?>

                <?=
                $this->render(
                    'content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]
                )
                ?>

            </div>

            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
