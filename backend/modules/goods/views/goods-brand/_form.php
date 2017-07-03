<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\file_input\FileInput;
use common\models\GoodsCategoryModel;
/* @var $this yii\web\View */
/* @var $model common\models\GoodsBrandModel */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="goods-brand-model-form">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data'],
        'fieldConfig' => [
            'template' => '<div class="row"><div class="col-sm-2">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>

    <?= $form->field($model, 'cat_id')->dropDownList(GoodsCategoryModel::getGoodsCategory()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo')->widget(\kartik\file\FileInput::className(), [
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

    <?= $form->field($model, 'desc')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>

    <button class="btn btn-primary btn-flat" type="submit">保存</button>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
window.onload = function(){
	var response = {"form":"GoodsBrandForm","field":"logo","url":"<?=$model->logo?>","state":"SUCCESS"}
	createInputElement(response, false)
	console.log(response)
}
</script>