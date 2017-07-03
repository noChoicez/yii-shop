<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @package yii2-widgets
 * @subpackage yii2-widget-fileinput
 * @version 1.0.5
 * 
 * // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ 示例  ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
 * $form->field($model, 'banner[]')->label('banner图')->widget(FileInput::classname(), [
    'options' => ['multiple' => true],
    'pluginOptions' => [
        // 需要预览的文件格式
        'previewFileType' => 'image',
        // 预览的文件
        'initialPreview' => $p1,
        // 需要展示的图片设置，比如图片的宽度等
        'initialPreviewConfig' => $p2,
        // 是否展示预览图
        'initialPreviewAsData' => true,
        // 异步上传的接口地址设置
        'uploadUrl' => Url::toRoute(['/goods/async-banner']),
        // 异步上传需要携带的其他参数，比如商品id等
        'uploadExtraData' => [
            'goods_id' => $id,
        ],
        'uploadAsync' => true,
        // 最少上传的文件个数限制
        'minFileCount' => 1,
        // 最多上传的文件个数限制
        'maxFileCount' => 10,
        // 是否显示移除按钮，指input上面的移除按钮，非具体图片上的移除按钮
        'showRemove' => true,
        // 是否显示上传按钮，指input上面的上传按钮，非具体图片上的上传按钮
        'showUpload' => true,
        //是否显示[选择]按钮,指input上面的[选择]按钮,非具体图片上的上传按钮
        'showBrowse' => true,
        // 展示图片区域是否可点击选择多文件
        'browseOnZoneClick' => true,
        // 如果要设置具体图片上的移除、上传和展示按钮，需要设置该选项
        'fileActionSettings' => [
            // 设置具体图片的查看属性为false,默认为true
            'showZoom' => false,
            // 设置具体图片的上传属性为true,默认为true
            'showUpload' => true,
            // 设置具体图片的移除属性为true,默认为true
            'showRemove' => true,
        ],
    ],
    // 一些事件行为
    'pluginEvents' => [
    	//自动上传
        'filebatchselected' => "function(event, files) {
            $(this).fileinput('upload')
	    }",
	    //上传成功之后执行的事件
    	'fileuploaded'  => "function (object,data){
			console.log(data)
        }",
        //删除成功之后执行的事件
   		'filedeleted' => "function(event, key, jqXHR, data) {
   		    console.log('Key = ' + key)
    		console.log(data)
		}",
    ],
]);
 */

namespace kartik\file;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\base\InputWidget;
use kartik\base\TranslationTrait;

/**
 * Wrapper for the Bootstrap FileInput JQuery Plugin by Krajee. The FileInput widget is styled for Bootstrap 3.0 with
 * ability to multiple file selection and preview, format button styles and inputs. Runs on all modern browsers
 * supporting HTML5 File Inputs and File Processing API. For browser versions IE9 and below, this widget will
 * gracefully degrade to normal HTML file input.
 *
 * @see http://plugins.krajee.com/bootstrap-fileinput
 * @see https://github.com/kartik-v/bootstrap-fileinput
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 2.0
 * @see http://twitter.github.com/typeahead.js/examples
 */
class FileInput extends InputWidget
{
    use TranslationTrait;

    /**
     * @var bool whether to resize images on client side
     */
    public $resizeImages = false;

    /**
     * @var bool whether to load sortable plugin to rearrange initial preview images on client side
     */
    public $sortThumbs = true;

    /**
     * @var bool whether to load dom purify plugin to purify HTML content in purfiy
     */
    public $purifyHtml = true;

    /**
     * @var bool whether to show 'plugin unsupported' message for IE browser versions 9 & below
     */
    public $showMessage = true;

    /*
     * @var array HTML attributes for the container for the warning
     * message for browsers running IE9 and below.
     */
    public $messageOptions = ['class' => 'alert alert-warning'];

    /**
     * @var array the internalization configuration for this widget
     */
    public $i18n = [];

    /**
     * @inheritdoc
     */
    public $pluginName = 'fileinput';

    /**
     * @var array the list of inbuilt themes
     */
    private static $_themes = ['fa', 'gly'];

    /**
     * @var array initialize the FileInput widget
     */
    public function init()
    {
        parent::init();
        $this->_msgCat = 'fileinput';
        $this->initI18N(__DIR__);
        $this->initLanguage();
        $this->registerAssets();
        if ($this->pluginLoading) {
            Html::addCssClass($this->options, 'file-loading');
        }
        $input = $this->getInput('fileInput');
        $script = 'document.getElementById("' . $this->options['id'] . '").className.replace(/\bfile-loading\b/,"");';
        if ($this->showMessage) {
            $validation = ArrayHelper::getValue($this->pluginOptions, 'showPreview', true) ?
                Yii::t('fileinput', 'file preview and multiple file upload') :
                Yii::t('fileinput', 'multiple file upload');
            $message = '<strong>' . Yii::t('fileinput', 'Note:') . '</strong> ' .
                Yii::t(
                    'fileinput',
                    'Your browser does not support {validation}. Try an alternative or more recent browser to access these features.',
                    ['validation' => $validation]
                );
            $content = Html::tag('div', $message, $this->messageOptions) . "<script>{$script};</script>";
            $input .= "\n" . $this->validateIE($content);
        }
        echo $input;
    }

    /**
     * Validates and returns content based on IE browser version validation
     *
     * @param string $content
     * @param string $validation
     *
     * @return string
     */
    protected function validateIE($content, $validation = 'lt IE 10')
    {
        return "<!--[if {$validation}]><br>{$content}<![endif]-->";
    }

    /**
     * Registers the asset bundle and locale
     */
    public function registerAssetBundle()
    {
        $view = $this->getView();
        if ($this->resizeImages) {
            CanvasBlobAsset::register($view);
            $this->pluginOptions['resizeImage'] = true;
        }
        $theme = ArrayHelper::getValue($this->pluginOptions, 'theme');
        if (!empty($theme) && in_array($theme, self::$_themes)) {
            FileInputThemeAsset::register($view)->addTheme($theme);
        }
        if ($this->sortThumbs) {
            SortableAsset::register($view);
        }
        if ($this->purifyHtml) {
            DomPurifyAsset::register($view);
            $this->pluginOptions['purifyHtml'] = true;
        }
        FileInputAsset::register($view)->addLanguage($this->language, '', 'js/locales');
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $this->registerAssetBundle();
        $this->registerPlugin($this->pluginName);
    }
}
