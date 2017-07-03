<?php
/**
 * 图片上传组件
 */
namespace common\widgets\file_input;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class FileInput extends InputWidget
{
    public $forms = [];
    public $config = [];
    
    public function init()
    {
        $_config = [
            'options'   => [
                'accept'  => 'images/*',
                'multiple' => false,
            ], 
            'pluginOptions' => [
                'uploadUrl' => Url::to(['upload']),
                'language'  => 'zh',
                'showUpload' => false,
                'showCancel' => false,
                'showRemove' => false,
                'showPreview'=> false,
                'uploadExtraData' => [
                    'name' => ''   //这个参数可以省略，额外的POST数据，我这里用来保存图片的属性到数据库中方便管理图片资源rotatain为Rotatain AR模型
                ]
            ],
            'pluginEvents'  => $this->pluginEvents(),
        ];
        $this->config = ArrayHelper::merge($_config, $this->config);
    }
    
    public function run()
    {   
        return $this->render('index',[
            'forms'=>$this->forms,
            'config' => $this->config,
        ]);
    }
    
    private function pluginEvents()
    {
        return [
            'filebatchselected' => "function(event, files) { 
                $(this).fileinput('upload')
            }",
            'fileuploaded'  => "function (object,data){
                console.log(data)
                if(data.response.state == 'SUCCESS'){
                    var field = $('.field-'+data.extra.name).find('input')
                    if(data.response.uploadnumber == '1'){
                        field[0].value = data.response.url 
                    }else{
                        field[0].value = field[0].value + data.response.url  
                    }
                    $('.file-caption-name').html(data.response.url)
                    layer.msg('上传成功', {time: 1000});
                }else{
                    layer.msg(data.response.state, {time: 1000});
                }
                
            }",
            'fileuploaderror' => "function (event, data){
                console.log(data)
            }",
            //错误的冗余机制
            'error' => "function (){
                alert('图片上传失败');
            }"
        ];
    }

}