<?php
use yii\helpers\Html;
use yii\widgets\Menu;

?>
<?php
echo Menu::widget([
    'items' => [
        ['label' => \Yii::t('localInfo', 'General Information'), 'url' => ['local-info/view', 'id' => $model->id], 'options' => ['class' => 'local-pins_icon general_information']],
        ['label' => \Yii::t('localInfo', 'Entry & Formalities'), 'url' => ['local-info/view-entry', 'id' => $model->id], 'options' => ['class' => 'local-pins_icon entry_formalities']],
        ['label' => \Yii::t('localInfo', 'Weather & Tides'), 'url' => ['local-info/view-weather-tides', 'id' => $model->id], 'options' => ['class' => 'local-pins_icon weather_tides']],
        ['label' => \Yii::t('localInfo', 'Nautic & Navigation'), 'url' => ['local-info/view-nautic-navigation', 'id' => $model->id], 'options' => ['class' => 'local-pins_icon nautic_navigation']],
        ['label' => \Yii::t('localInfo', 'Business & Services'), 'url' => ['local-info/view-business-services', 'id' => $model->id], 'options' => ['class' => 'local-pins_icon business_sevices']],
        ['label' => \Yii::t('localInfo', 'Local Life'), 'url' => ['local-info/view-local-life', 'id' => $model->id], 'options' => ['class' => 'local-pins_icon local_life']],
    ],
    'options' => ['class' => 'container local-pins'],
    'linkTemplate' => '<a href="{url}"><span></span>{label}</a>',
]);

?>
