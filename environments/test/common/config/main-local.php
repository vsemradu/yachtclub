<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=gbksoft.net;dbname=yachtadvisor_test',
            'username' => 'yachtadviso_test',
            'password' => 'tnxFVu9t7z',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => 'sender.gbksoft@gmail.com',
//                'password' => 'Sned4romGmailMail',
//                'port' => '587',
//                'encryption' => 'tls',
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                    //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\widgets\PjaxAsset' => [
                    'sourcePath' => '@app/web/js', // do not publish the bundle
                    'js' => [
                        'jquery.pjax.js',
                    ]
                ],
            ],
        ],
    ],
];
