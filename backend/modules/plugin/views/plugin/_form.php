<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PluginModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plugin-model-form">

    <?php $form = ActiveForm::begin([
    	'options'=>['enctype'=>'multipart/form-data'],
        'fieldConfig' => [
            'template' => '<div class="row"><div class="col-sm-2 max-width-120">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>
	
	<ul class="nav nav-tabs" role="tablist" style="margin-bottom:20px;">
	    <li role="presentation" class="active">
	        <a href="#info" aria-controls="info" role="tab" data-toggle="tab">基本信息</a>
	    </li>
	    <li role="presentation">
	        <a href="#config" aria-controls="config" role="tab" data-toggle="tab">配置信息</a>
	    </li>
	</ul>
  
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="info">
		
			<?= $form->field($model, 'type')->dropDownList(['payment' => '支付插件', 'shipping'=>'物流插件', 'custom'=>'自定义插件'],['prompt'=>'请选择', 'id'=>'type']) ?>

		    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
		
		    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
			
			<?= $form->field($model, 'cover_image')->widget(\kartik\file\FileInput::className(), [
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
		
		    <?= $form->field($model, 'back_image')->widget(\kartik\file\FileInput::className(), [
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
		    			console.log(data)
						createInputElement(data.response, true)
		            }",
		    	]
            ]) ?>
			
		    <?= $form->field($model, 'desc')->textarea(['rows' => 2]) ?>
		    
		</div>
		<div role="tabpanel" class="tab-pane fade in" id="config">
			<div class=" form-group">
				<?= Html::button('添加配置项', ['class' => 'btn btn-info btn-flat','id'=>'addConfig']) ?>
			</div>
			<table class="table table-bordered">
				<thead>
					<th>Type</th>
					<th>Label</th>
					<th>Code</th>
					<th>Value</th>
					<th>Action</th>
				</thead>
				<tbody id="input"></tbody>
			</table>
		</div>
	</div>
	
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
window.onload=function()
{
	<?php $display = ($model->type == "shipping")?"block":"none";?>

	/**
	* 图片初始化
	*/
	var response1 = {"form":"PluginForm","field":"cover_image","url":"<?=$model->cover_image?>","state":"SUCCESS"}
	var response2 = {"form":"PluginForm","field":"back_image","url":"<?=$model->back_image?>","state":"SUCCESS"}
	createInputElement(response1, false)
	createInputElement(response2, false)
	
	var back_image = document.getElementsByClassName("field-pluginform-back_image")[0]
	back_image.style.display = "<?=$display ?>"

	document.getElementById("type").addEventListener("change",function(){
		(this.value == "shipping")?back_image.style.display = "block" : back_image.style.display = "none"
	})	
	
	/**
	* 配置初始化
	*/
	<?php if(isset($model->config)):
		foreach($model->config as $k => $v):
	?>
		createInputElementForPlugin(["<?=$v['type']?>","<?=$v['label']?>","<?=$v['code']?>",<?=$v['value']?>]);
	<?php endforeach;endif;?>
	
	document.getElementById("addConfig").addEventListener("click",function(){
		createInputElementForPlugin();
	})	
}

function createInputElementForPlugin(arr = ['','','',''])
{
	var tr = document.createElement("tr")
	var input = document.getElementById("input")
	var str = ''
	str += '<td><select class="form-control" name="PluginForm[config][type][]" required>'
	str += '<option value="text" '+ ((arr[0] == 'text')?'selected':'') + '>text</option>'
	str += '<option value="radio" '+ ((arr[0] == 'radio')?'selected':'') + '>radio</option>'
	str += '<option value="select" '+ ((arr[0] == 'select')?'selected':'') + '>select</option>'	
	str += '<option value="checkbox" '+ ((arr[0] == 'checkbox')?'selected':'') + '>checkbox</option>'
	str += '<select></td>'
	str += '<td><input class="form-control" name="PluginForm[config][label][]" value="'+ arr[1] +'" placeholder="配置名称" required></td>'
	str += '<td><input class="form-control" name="PluginForm[config][code][]" value="'+ arr[2] +'" placeholder="配置标识" required></td>'
	str += "<td><input class='form-control' name='PluginForm[config][value][]' value='"+ ((typeof arr[3] == "object")? JSON.stringify(arr[3]):arr[3]) +"' placeholder='配置项值,数据格式JSON'  required></td>"
	str += '<td><button class="btn btn-danger btn-flat" onclick="this.parentNode.parentNode.remove()">Delete</button></td>'
	
	tr.innerHTML = str
	input.appendChild(tr)
}
</script>
