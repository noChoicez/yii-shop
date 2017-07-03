<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PluginModel */

$this->title = '添加地区';
$this->params['breadcrumbs'][] = ['label' => '插件工具', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '插件列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-model-create">
    <div class="box">
		<div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>
        <div class="box-body">
        	<?php $form = ActiveForm::begin([
		    	'options'=>['enctype'=>'multipart/form-data'],
		        'fieldConfig' => [
		            'template' => '<div class="row"><div class="col-sm-2 max-width-120">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
		            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
		        ],
		    ]); ?>
		
			<?= $form->field($model, 'name')->textInput()?>
			
			<?= $form->field($model, 'first_weight')->dropDownList([500=>'500'])?>
			
			<?= $form->field($model, 'first_money')->textInput()?>
			
			<?= $form->field($model, 'add_weight')->dropDownList([500=>'500'])?>
			
			<?= $form->field($model, 'add_money')->textInput()?>
		    
		    <?= $form->field($model, 'plugin_id',['options'=>['style'=>['display'=>'none']]])->hiddenInput(['value'=>Yii::$app->request->get('plugin_id')]);?>
		    
		    <div class="form-group">
		    	<div class="row">
		    		<div class="col-sm-2 max-width-120">
		    			<label>地区：</label>
		    		</div>
		    		<div class="col-sm-10">
		    			<div class="row">
		    				<div class="col-sm-8" id="area"></div>
		    			</div>
		    		</div>
		    	</div>
		    </div>
		    
		    <div class="form-group">
		    	<div class="row">
		    		<div class="col-sm-2 max-width-120"></div>
		    		<div class="col-sm-10">

		    			<?=Html::dropDownList('province',null,$province,[
		    					'multiple'=>false, 
		    					'prompt' => '请选择',
		    					'size'=>5,
		    					'id'=>'province',
		    					'class'=>'form-control list pull-left mr20',
		    					'style'=>['height'=>'200px','width'=> 'auto'],
		    					'onchange' => 'getCity(this.value)',
		    			])?>

		    			<?=Html::dropDownList('province',null,[],[
		    					'multiple'=>false, 
		    					'prompt' => '请选择',
		    					'size'=>5,
		    					'id'=>'city',
		    					'class'=>'form-control list pull-left mr20',
		    					'style'=>['height'=>'200px','width'=> 'auto'],
		    					'onchange' => 'getDistrict(this.value)',
		    					
		    			])?>

		    			<?=Html::dropDownList('province',null,[],['multiple'=>false, 'prompt' => '请选择','size'=>5,'id'=>'district','class'=>'form-control list pull-left mr20','style'=>['height'=>'200px','width'=> 'auto']])?>

		    			<?=Html::button('添加',['id'=>'addArea','class'=>'btn btn-info btn-flat'])?>

			    	</div>
		    	</div>
		    </div>
		    
		    <div class="form-group">
		        <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-flat']) ?>
		    </div>
		
		    <?php ActiveForm::end(); ?>
    
		</div>
	</div>
</div>

<script>
/**
 * 初始化地区
 */
<?php 
if(isset($model->area)):
	foreach($model->area as $k => $v):	
?>
	createCheckBox(<?=$v['area']['id']?>, "<?=$v['area']['name']?>");
<?php 
	endforeach;;
endif;
?>

document.getElementById("addArea").addEventListener("click", function(){
	var values = []
	var value,text
	var checkboxes = document.querySelectorAll('[name="PluginShippingForm[area][]"]')
	var province = document.getElementById("province")
	var city = document.getElementById("city")
	var district = document.getElementById("district")
	checkboxes.forEach( i =>{
		values.push(i.value)
	})

	if(district.selectedIndex > 0){
		value = district.options[district.selectedIndex].value
		text  = district.options[district.selectedIndex].text
	}else if(city.selectedIndex > 0){
		value = city.options[city.selectedIndex].value
		text  = city.options[city.selectedIndex].text
	}else if(province.selectedIndex > 0){
		value = province.options[province.selectedIndex].value
		text  = province.options[province.selectedIndex].text
	}else{
		layer.msg("请选择地区", {time: 1000});
		return false;
	}
	if(!value){
		layer.msg("请选择地区", {time: 1000});
		return false;
	}
	for(var i of values){
		if(i == value){
			layer.msg(text+'已存在,不能重复添加', {time: 1000});
			return false;
		}
	}
	
	createCheckBox(value, text);
})

function createCheckBox(value,text)
{
	var label = document.createElement("label")
	var area = document.getElementById("area")
	var check = "<input type='checkbox' name='PluginShippingForm[area][]' value='"+ value +"' checked> "+ text +""
	label.innerHTML = check
	area.appendChild(label)	
}

function getCity(id)
{
	$.post("<?=Url::to(['/plugin/plugin/shipping-create'])?>",{province:id},function(res){
		var city = document.getElementById("city");
		city.options.length = 0		
		city.options.add(new Option('请选择',''))
		if(res){
			var object = JSON.parse(res)
			for (var i of object){
				city.options.add(new Option(i.name,i.id))
			}
		}
	})
}

function getDistrict(id)
{
	$.post("<?=Url::to(['/plugin/plugin/shipping-create'])?>",{city:id},function(res){
		var city = document.getElementById("district");
		city.options.length = 0		
		city.options.add(new Option('请选择',''))
		if(res){
			var object = JSON.parse(res)
			for (var i of object){
				city.options.add(new Option(i.name,i.id))
			}
		}
	})
}
</script>
