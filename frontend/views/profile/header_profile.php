<?php
use yii\widgets\Menu;
use common\models\User;
use common\models\UserPin;

$user = User::findIdentity(Yii::$app->user->id);
$modelPins = UserPin::find()->where(['user_id' => Yii::$app->user->id])->count();

?>

<div class="profile-header">

    <div class="row">
        <div class="col-lg-4">
            <div class="media">
                <div class="media-left">
                    <?php if (!empty($user->userInfo->imageUrl)) { ?>
                        <div class="photo" style="background:url(<?= $user->userInfo->imageUrl ?>)no-repeat center;background-size:cover;"></div>
                    <?php } else { ?>
                        <div class="photo"></div>
<?php } ?>
                </div>
                <div class="media-body">
                    <div class="name">
<?= $user->userInfo->fullName ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="profile-header-info">
                <p>
                    <span><?= \Yii::t('profile', 'Location:'); ?></span>
<?= $user->userInfo->location ?>
                </p>

                <p>
                    <span><?= \Yii::t('profile', 'All Pages:'); ?></span>
                    <a href="#">
<?= $user->userPageCount ?> Pages
                    </a>
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="profile-header-info">
                <p>
                    <span><?= \Yii::t('profile', 'All Pins:'); ?></span>
                    <a href="#">
<?= count($user->userPin) ?> Pins
                    </a>
                </p>

                <p>
                    <span><?= \Yii::t('profile', 'All Reviews:'); ?></span>
                    <a href="#">
<?= count($user->userReview) ?> Reviews
                    </a>
                </p>
            </div>
        </div>
    </div>

    <?=
    Menu::widget([
        'items' => [
            ['label' => \Yii::t('profile', 'My Pages'), 'url' => ['profile/index']],
            ['label' => \Yii::t('profile', 'My Pins'), 'url' => ['profile/pins']],
            ['label' => \Yii::t('profile', 'My reviews'), 'url' => ['profile/reviews']],
            ['label' => \Yii::t('profile', 'Edit profile'), 'url' => ['profile/edit']],
        ],
        'options' => ['class' => 'profile-header-inner-menu'],
    ]);

    ?>

</div>

