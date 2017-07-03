<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'statics/css/fonts.googleapis.com.css',
		'statics/css/animate.css',
		'statics/css/fontello.css',
		'statics/css/settings.css',
		'statics/css/owl.carousel.css',
		'statics/css/style.css',
		'statics/css/jquery.arcticmodal.css',
    	'statics/css/swiper-3.4.2.min.css',
    ];
    public $js = [
    		'statics/js/modernizr.js',
    		'statics/js/queryloader2.min.js',
    		'statics/js/jquery.elevateZoom-3.0.8.min.js',
    		'statics/js/jquery.fancybox.pack.js',
    		'statics/js/jquery.fancybox-media.js',
    		'statics/js/jquery.fancybox-thumbs.js',
    		'statics/js/jquery.themepunch.tools.min.js',
    		'statics/js/jquery.themepunch.revolution.min.js',
    		'statics/js/jquery.appear.js',
    		'statics/js/owl.carousel.min.js',
    		'statics/js/jquery.countdown.plugin.min.js',
    		'statics/js/jquery.countdown.min.js',
    		'statics/js/jquery.arcticmodal.js',
    		'statics/js/jquery.tweet.min.js',
    		'statics/js/colorpicker.js',
    		'statics/js/retina.min.js',
    		'statics/js/theme.plugins.js',
    		'statics/js/theme.core.js',
    		'statics/js/function.js',
    		'statics/js/swiper-3.4.2.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
