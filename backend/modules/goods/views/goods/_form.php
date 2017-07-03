<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GoodsCategoryModel;
use common\models\GoodsBrandModel;
use common\models\GoodsTypeModel;


/* @var $this yii\web\View */
/* @var $model common\models\GoodsModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-model-form">

    <?php $form = ActiveForm::begin([
    	'options'=>['enctype'=>'multipart/form-data'],
        'fieldConfig' => [
            'template' => '<div class="row"><div class="col-sm-2 max-width-120">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>
    
    <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" style="margin-bottom:20px;">
    <li role="presentation" class="active">
        <a href="#info" aria-controls="info" role="tab" data-toggle="tab">商品信息</a>
    </li>
    <li role="presentation">
        <a href="#album" aria-controls="album" role="tab" data-toggle="tab">商品相册</a>
    </li>
    <li role="presentation">
        <a href="#spec" aria-controls="spec" role="tab" data-toggle="tab">商品规格</a>
    </li>
    <li role="presentation">
        <a href="#attribute" aria-controls="attribute" role="tab" data-toggle="tab">商品属性</a>
    </li>
  </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="info">

            <?= $form->field($model, 'cat_id')->dropDownList(GoodsCategoryModel::getGoodsCategory()) ?>

            <?= $form->field($model, 'brand_id')->dropDownList(GoodsBrandModel::getGoodsBrand()) ?>

            <?= $form->field($model, 'goods_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'goods_image')->widget(\kartik\file\FileInput::className(), [
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

            <?= $form->field($model, 'goods_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'goods_keyword')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'goods_remark')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'goods_weight')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'market_price')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'shop_price')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'cost_price')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'stock_count')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'is_free_shipping')->dropDownList([0=>'否', 1=>'是']) ?>

            <?= $form->field($model, 'goods_desc', [
                'template' => '<div class="row"><div class="col-sm-2 max-width-120">{label}：</div><div class="col-sm-10">{input}{error}</div></div>',
                ])->widget('common\widgets\ueditor\Ueditor',[
                'options' => [
                    'initialFrameHeight' => 350,
                ]
            ]) ?> 

        </div>
        <div role="tabpanel" class="tab-pane fade" id="album">
            <?= $form->field($model, 'album[]', [
                'template' => '<div class="row"><div class="col-sm-12">{input}{error}</div></div>',
            ])->widget(\kartik\file\FileInput::className(), [
                'options'=>['multiple'=>true],
		   		'pluginOptions'=>[
	    			'showUpload' => false,
	    			'showCancel' => false,
	    			'showRemove' => false,
		   			'showDelete' => false,
		   			'overwriteInitial' => false,
	    			//'showPreview'=> false,
	    			'uploadUrl' =>Url::to(['upload','action'=>'uploadimage']),
		   			'initialPreviewConfig' => isset($model->album['initialPreviewConfig'])?$model->album['initialPreviewConfig']:[],
		   			'initialPreview' => isset($model->album['initialPreview'])?$model->album['initialPreview']:[],
		   		],
		    	'pluginEvents' => [
			    	'filebatchselected' => "function(event, files) {
			            $(this).fileinput('upload')
			        }",
		    		'fileuploaded'  => "function (object,data){
						createInputElement(data.response, true)
		            }",
		    		'filedeleted' => "function(event, key, jqXHR, data) {
					    deleteInputElement(data, 'GoodsForm[album][]')
					}",
		    	]
            ]) ?>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="spec">
        
	        <?= $form->field($model, 'spec[type_id]',['labelOptions'=>['label'=>'商品类型']])->dropDownList(GoodsTypeModel::getGoodsType(),[
	        	'class' => 'form-control', 
	        		'style' => ['width' => '400px'],
	        		'onchange' => '$.post("'.Url::to(['goods/ajax']).'",{action:"getSpecItems",type_id:this.value}, function(data){
	        			$("#goods_spec_table").html("")
	        			$("#goods_spec").html("")
	        			$("#goods_spec").append(data)
					})',
	        ])?>

       		<div id="goods_spec"></div>
       		
       		<div id="goods_spec_table"></div>
			
			
		</div>
        <div role="tabpanel" class="tab-pane fade" id="attribute">
        	<?= $form->field($model, 'attribute[type_id]',['labelOptions'=>['label'=>'商品属性']])->dropDownList(GoodsTypeModel::getGoodsType(),[
	        	'class' => 'form-control', 
	        		'style' => ['width' => '400px'],
	        		'onchange' => '$.post("'.Url::to(['goods/ajax']).'",{action:"getAttribute",type_id:this.value}, function(data){
	        			$("#goods_attribute").html("")
	        			$("#goods_attribute").append(data)
					})',
	        ])?>
	        
	        <div id="goods_attribute"></div>
	        
        </div>
    </div>
    
    <button class="btn btn-primary btn-flat" type="submit">保存</button>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
window.onload = function(){
	/**
	* 图片初始化
	*/
	var response = {"form":"GoodsForm","field":"goods_image","url":"<?=$model->goods_image?>","state":"SUCCESS"}
	createInputElement(response, false)
	<?php 
	if(isset($model->album['createInputElement'])):
		foreach($model->album['createInputElement'] as $k => $v):
			$createInputElement[$k] = json_encode($v);	
	?>
	createInputElement(<?=$createInputElement[$k]?>, false)
    <?php 
    	endforeach;
    endif;
    ?>
	
    /**
    * 规格初始化
    */
    $.post("<?=Url::to(['goods/ajax'])?>",{action:"getSpecItems",type_id:<?=$model->spec['type_id']?:0?>,goods_id:<?=$model->id?:0 ?>}, function(data){
		$("#goods_spec").html("")
		$("#goods_spec").append(data)
		ajaxGetSpecInputArr(<?=$model->id?>);
	})

	/**
	* 属性初始化
	*/
	$.post("<?=Url::to(['goods/ajax'])?>",{action:"getAttribute",type_id:<?=$model->attribute['type_id']?:0?>,goods_id:<?=$model->id?:0 ?>}, function(data){
		$("#goods_attribute").html("")
		$("#goods_attribute").append(data)
	})
	  
}
</script>
