<?php
use yii\widgets\Menu;

?>
<aside class="left-side sidebar-offcanvas">

    <section class="sidebar">

        <?php if (!Yii::$app->user->isGuest) : ?>
            <div class="user-panel">
                <div class="pull-left image">



                    <?php if (!empty(@Yii::$app->user->identity->userInfo->imageUrl)) { ?>

                        <img src="<?= @Yii::$app->user->identity->userInfo->imageUrl ?>" class="img-circle" alt="User Image"/>
                    <?php } else { ?>
                        <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle" alt="User Image"/>
                    <?php } ?>
                </div>
                <div class="pull-left info">
                    <p><?= \Yii::t('admin', 'Hello, '); ?><?= @Yii::$app->user->identity->userInfo->first_name ?></p>
                    <a href="<?= $directoryAsset ?>/#">
                        <i class="fa fa-circle text-success"></i> <?= \Yii::t('admin', 'Online'); ?>
                    </a>
                </div>
            </div>
        <?php endif ?>

        <?php
        $menuItems = [
            ['label' => '<i class="fa fa-dashboard"></i>Dashboard', 'url' => ['/site/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '<i class="fa fa-folder"></i>Login', 'url' => ['/site/login']];
        } else {
            if (\common\models\User::hasBackendAccess()) {
                $menuItems[] = [
                    'label' => '<i class="fa fa-folder"></i>Blog', 'url' => ['/blog-post/index'],
                ];
                $menuItems[] = [
                    'label' => '<i class="fa fa-folder"></i>Busines', 'url' => ['/busines/index'],
                ];
                $menuItems[] = [
                    'label' => '<i class="fa fa-folder"></i>Tip or Trick', 'url' => ['/local-info-comment/index'],
                ];
                $menuItems[] = [
                    'label' => '<i class="fa fa-folder"></i>Reviews',
                    'items' => [
                        ['label' => '<i class="fa fa-folder"></i>Busines Reviews', 'url' => ['/reviews/index-business'],],
                        ['label' => '<i class="fa fa-folder"></i>Pin Reviews', 'url' => ['/reviews/index-pin'],],
                        ['label' => '<i class="fa fa-folder"></i>Yacht Reviews', 'url' => ['/reviews/index-yacht'],],
                    ],
                    'url' => '#',
                    'options' => ['class' => 'treeview'],
                ];
                $menuItems[] = [
                    'label' => !empty($userPinNotAprroved) ? '<i class="fa fa-folder"></i>Pins (' . $userPinNotAprroved . ')' : '<i class="fa fa-folder"></i>Pins', 'url' => ['/user-pin/index'],
                ];
                $menuItems[] = [
                    'label' => '<i class="fa fa-folder"></i>Local Info', 'url' => ['/local-info/index'],
                ];
            }
        }

        ?>

        <?=
        Menu::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => $menuItems,
                'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
                'encodeLabels' => false,
                'activateParents' => true,
            ]
        );

        ?>


    </section>

</aside>
