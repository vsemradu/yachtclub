<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\file\FileInput;
use common\models\CrewMemberRole;

$uniqid = !empty($crewMember->id) ? $crewMember->id : uniqid();
?>

<div class="js-crew-block">
    <div class="row follow-information">
        <div class="col-md-6">

            <?= Html::activeInput('text', $crewMember, '[' . $uniqid . ']name', ['class' => 'form-control single-input', 'placeholder' => \Yii::t('yacht', 'Crew Name*'), 'label' => false]) ?>
            <div style="color: #a94442" class="offset-error">         <?= Html::error($crewMember, 'name') ?>   </div>
        </div>
        <div class="col-md-6">
            <div class="upload-block">
                <div class="input-group">
                    <?=
                    FileInput::widget([
                        'model' => $image,
                        'attribute' => '[\'crew\']upload_image[' . $uniqid . ']',
                        'options' => [

                            'accept' => 'image/*',
                            'multiple' => false,
                            'id' => uniqid()
                        ],
                        'pluginOptions' => [
                            'showRemove' => false,
                            'showUpload' => false,
                        ],
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>

    <h2 class="h2-title">
        <?= Yii::t('yacht', 'Roles') ?>
    </h2>

    <div class="row large-radio-list">
        <div class="col-md-12">
            <div class="row radio-list">

                <?php $key_role = 1; ?>
                <?php foreach ($crewMemberRole as $k => $role) { ?>

                    <?php if ($key_role == 1) { ?>
                        <div class="col-md-4 col-sm-6">
                        <?php } ?>

                        <div class="radio">
                            <?= Html::activeRadio($crewMember, '[' . $uniqid . ']role_id', ['class' => '', 'value' => $role->id, 'uncheck' => null, 'label' => false]) ?>
                            <?= $role->name ?>
                        </div>
                        <?php $key_role++; ?>


                        <?php if (count($crewMemberRole) == ($k + 1)) { ?>
                            <div class="radio">



                                <?= Html::activeRadio($crewMember, '[' . $uniqid . ']role_id', ['class' => '', 'value' => CrewMemberRole::TYPE_OTHER, 'uncheck' => null, 'label' => false]) ?>
                                <?= CrewMemberRole::itemAlias('[' . $uniqid . ']type_title', CrewMemberRole::TYPE_OTHER) ?>



                                <div class="text-other">

                                    <?= Html::activeInput('text', $crewMember, '[' . $uniqid . ']role', ['class' => 'form-control single-input', 'placeholder' => \Yii::t('yacht', 'Other'), 'label' => false]) ?>

                                </div>
                            </div>
                            <div style="color: #a94442;padding-left:15px;">    
                                <?= Html::error($crewMember, '[' . $uniqid . ']role') ?>
                            </div>
                        <?php } ?>
                        <?php if ($key_role == 9 OR count($crewMemberRole) == ($k + 1) && $k <= 20) { ?>


                        </div>
                        <?php $key_role = 1; ?>
                    <?php } ?>
                <?php } ?>






                <div style="color: #a94442;padding-left:15px;">    
                    <?= Html::error($crewMember, 'role_id') ?>
                </div>
            </div>
        </div>

    </div>
    <?php if (!empty($remove)) { ?>
        <a href="#" class="add-review-btn js-remove" data-id="<?php echo!empty($crewMember->id) ? $crewMember->id : ''; ?>" data-yacht_id="<?php echo!empty($model->id) ? $model->id : ''; ?>" >- Remove</a>
    <?php } ?>
    <hr>
</div>