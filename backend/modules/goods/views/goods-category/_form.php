<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GoodsCategoryModel;
use yii\helpers\Url;
use common\widgets\file_input\FileInput;
$GoodsCategory = GoodsCategoryModel::getGoodsCategory();
/* @var $this yii\web\View */
/* @var $model common\models\GoodsCategoryModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-category-model-form">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data'],
        'fieldConfig' => [
            'template' => '
                <div class="row">
                    <div class="col-sm-2 control-label">{label}：</div>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-8">{input}</div>
                            <div>{error}</div>
                        </div>
                    </div>
                </div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>
    
    <?= $form->field($model,'parent_id')->dropDownList(GoodsCategoryModel::getGoodsCategory(),['prompt'=>'请选择']) ?>
    
    <?= $form->field($model, 'cat_name')->textInput(['maxlength' => true, 'value'=>$model->cat_name]) ?>
    
    <?= $form->field($model, 'cat_image')->widget(\kartik\file\FileInput::className(), [
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


    <?= $form->field($model, 'cat_desc')->textarea(['maxlength' => true,'value'=>$model->cat_desc]) ?>

    <?= $form->field($model, 'order')->textInput(['value'=>$model->order]) ?>
    
    <?= $form->field($model, 'is_show')->dropDownList([1=>'是', 2=>'否']) ?>

    <button class="btn btn-primary btn-flat" type="submit">保存</button>

    <?php ActiveForm::end(); ?>
	
</div>
<script type="text/javascript">
window.onload = function(){
	var response = {"form":"GoodsCategoryForm","field":"cat_image","url":"<?=$model->cat_image?>","state":"SUCCESS"}
	createInputElement(response, false)
}
</script>
