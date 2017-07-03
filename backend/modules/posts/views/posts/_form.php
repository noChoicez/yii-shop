<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PostsCategoryModel;

/* @var $this yii\web\View */
/* @var $model common\models\PostsModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-model-form">

    <?php $form = ActiveForm::begin([
    	'options'=>['enctype'=>'multipart/form-data'],
        'fieldConfig' => [
            'template' => '<div class="row"><div class="col-sm-2 max-width-120">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>

    <?= $form->field($model, 'cat_id')->dropDownList(PostsCategoryModel::getPostsCategory()) ?>

    <?= $form->field($model, 'posts_title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'posts_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'posts_image')->widget(\kartik\file\FileInput::className(), [
   		'options'=>['multiple'=>false],
   		'pluginOptions'=>[
    			'showUpload' => false,
    			'showCancel' => false,
    			'showRemove' => false,
    			'showPreview'=> false,
    			'uploadUrl' =>Url::to(['upload','action'=>'uploadimage']),
   		],
    	'pluginEvents' => [
	    	'filebatchselected' => "function(event, files) {
	            $(this).fileinput('upload')
	        }",
    		'fileuploaded'  => "function (object,data){
				createInputElement(data.response, true)
            }",
    	]
    ]) ?>
    
    <?= $form->field($model, 'is_show')->dropDownList([1=>'是',0=>'否']) ?>

    <?= $form->field($model, 'is_open')->dropDownList([1=>'是',0=>'否']) ?>

    <?= $form->field($model, 'posts_link')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'posts_desc')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'posts_content', [
        'template' => '<div class="row"><div class="col-sm-2 max-width-120">{label}：</div><div class="col-sm-10">{input}{error}</div></div>',
    ])->widget('common\widgets\ueditor\Ueditor',[
        'options' => [
            'initialFrameHeight' => 350,
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
window.onload = function(){
	var response = {"form":"PostsForm","field":"posts_image","url":"<?=$model->posts_image?>","state":"SUCCESS"}
	createInputElement(response, false)
}
</script>