<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/owl.carousel.css',
        'css/main.css',
        'css/main_new.css',
    ];
    public $js = [
        'js/owl.carousel.min.js',
        'js/main.js',
        'js/jquery.htmlClean.min.js',
        'js/jquery.truncate.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        '\gietos\yii\ionicons\AssetBundle',
        '\rmrevin\yii\fontawesome\AssetBundle',
    ];
    public $jsOptions = [ 'position' => \yii\web\View::POS_HEAD];
    public $cssOptions = [ 'position' => \yii\web\View::POS_HEAD];

}
