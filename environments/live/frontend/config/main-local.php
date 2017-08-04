<?php
$config = [
    'name' => 'Nautic Nomad',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sOgQigEnTc6epi9bJTaP',
            'baseUrl' => '',
        ],
        'urlManager' => [
            'baseUrl' => 'http://yachtadvisor.live.gbksoft.net',
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
];

return $config;
