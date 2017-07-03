<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\PluginModel */

$this->title = '配置插件';
$this->params['breadcrumbs'][] = ['label' => '插件工具', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '插件列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-model-config">
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
		    
		    <?php if(isset($model->config)):
		    	foreach($model->config as $k => $v):
		    		if($v['type'] == 'text'):
		    ?>
		    	<?= $form->field($model, 'config_value['.$v['code'].']')->label($v['label'])->textInput() ?>
		    <?php elseif($v['type'] == 'radio'):?>
		    	<?= $form->field($model, 'config_value['.$v['code'].']')->label($v['label'])->radioList(json_decode($v['value'],true)) ?>
		    <?php elseif($v['type'] == 'checkbox'):?>
		    	<?= $form->field($model, 'config_value['.$v['code'].']')->label($v['label'])->checkboxList(json_decode($v['value'],true)) ?>
		    <?php elseif($v['type'] == 'select'):?>
		    	<?= $form->field($model, 'config_value['.$v['code'].']')->label($v['label'])->dropDownList(json_decode($v['value'],true),['prompt' => '请选择']) ?>
		    <?php endif;?>
		    <?php endforeach;endif;?>
		    
		    <div class="form-group">
		        <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-flat']) ?>
		    </div>
		
		    <?php ActiveForm::end(); ?>
		    
		</div>
	</div>
</div>
