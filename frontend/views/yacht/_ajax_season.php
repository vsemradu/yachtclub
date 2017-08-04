<?php
use yii\helpers\Url;
use yii\helpers\Html;

$uniqid = !empty($yachtSeason->id) ? $yachtSeason->id : uniqid();

?>

<div class="js-season-block">
    <div class="col-md-12">
        <div class="row edit-location">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?= Html::activeInput('text', $yachtSeason, '[' . $uniqid . ']season', ['class' => '', 'placeholder' => \Yii::t('yacht', 'Season and Cruising Grounds*'), 'label' => false]) ?>
                        <div style="color: #a94442">                       
                            <?= Html::error($yachtSeason, 'season') ?>
                        </div>

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group">


                        <?= Html::activeInput('text', $yachtSeason, '[' . $uniqid . ']from', ['class' => '', 'placeholder' => \Yii::t('yacht', 'From'), 'label' => false]) ?>
                        <div style="color: #a94442;">
                            <?= Html::error($yachtSeason, 'from') ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group">

                        <?= Html::activeInput('text', $yachtSeason, '[' . $uniqid . ']to', ['class' => '', 'placeholder' => \Yii::t('yacht', 'To'), 'label' => false]) ?>
                        <div style="color: #a94442;">
                            <?= Html::error($yachtSeason, 'to') ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">

                        <?= Html::activeInput('text', $yachtSeason, '[' . $uniqid . ']currency', ['class' => '',  'maxlength'=>3, 'placeholder' => \Yii::t('yacht', '$'), 'label' => false]) ?>
                        <div style="color: #a94442;">
                            <?= Html::error($yachtSeason, 'currency') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($remove)) { ?>
        <a href="#" data-id="<?php echo!empty($yachtSeason->id) ? $yachtSeason->id : ''; ?>" data-yacht_id="<?php echo!empty($model->id) ? $model->id : ''; ?>" class="js-season-remove add-email">- Remove</a>
    <?php } ?>
    <hr>
</div>