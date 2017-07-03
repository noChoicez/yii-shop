<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'statics/js/datepicker/datepicker3.css',
    	'statics/css/site.css',
    ];
    public $js = [
    	'statics/js/datepicker/bootstrap-datepicker.js',
    	'statics/js/datepicker/locales/bootstrap-datepicker.zh-CN.js',
        'statics/js/layer/layer.js',
        'statics/js/functions.js',
    	'statics/js/footer.js',
    	
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

