<?php
use yii\widgets\ActiveForm;
use common\widgets\file_input\FileInput;
use yii\helpers\Url;
use yii\base\Widget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '网站设置 ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-model-index">
	<div class="panel panel-default">  
		<div class="panel-body">
      		<ul class="nav nav-tabs" role="tablist" style="margin-bottom:20px;">
        		<li role="presentation" class="active"><a href="#site" aria-controls="site" role="tab" data-toggle="tab"><?=Yii::t('common', 'site_info')?></a></li>
				<li role="presentation" class=""><a href="#smtp" aria-controls="smtp" role="tab" data-toggle="tab"><?=Yii::t('common', 'smtp_info')?></a></li>
      		</ul>
            
            <?php $form=ActiveForm::begin([
            'options'=>['enctype'=>'multipart/form-data'],
                'fieldConfig' => [
                    'template' => '<div class="row"><div class="col-sm-2">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
                    'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
                ],
            ]);?>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="site"> 	  
                
            		<?=$form->field($model, 'site_url')->textInput(['value'=>$value['site_url']])?>
            		
            		<?=$form->field($model, 'site_record')->textInput(['value'=>$value['site_record']])?>
            		
            		<?=$form->field($model, 'site_name')->textInput(['value'=>$value['site_name']])?>
            		
                    <?=FileInput::widget([
                        'forms' => [
                            'form'=>$form,
                            'model'=>$model,
                            'attribute'=>'site_logo',
                            'value' => $value['site_logo'],
                        ],
                        'config' => [
                            'options'=>[
                                'multiple'=>false ,     
                            ],
                            'pluginOptions'=>[
                              //'showUpload'=>true,
                              'uploadUrl' =>Url::to(['upload','action'=>'uploadimage','FieldName'=>'site_logo','FormName'=>'ConfigForm','uploadnumber'=>1]),
                              'uploadExtraData'=>[
                                  'name' => 'configform-site_logo'       
                              ]
                            ],        
                        ],
                            
                    ])?>
            		
            		<?=$form->field($model, 'site_title')->textInput(['value'=>$value['site_title']])?>
            		
            		<?=$form->field($model, 'site_desc')->textInput(['value'=>$value['site_desc']])?>
            		
            		<?=$form->field($model, 'site_keyword')->textInput(['value'=>$value['site_keyword']])?>
            		
            		<?=$form->field($model, 'site_contact')->textInput(['value'=>$value['site_contact']])?>
            		
            		<?=$form->field($model, 'site_phone')->textInput(['value'=>$value['site_phone']])?>
            		
            		<?=$form->field($model, 'site_address')->textInput(['value'=>$value['site_address']])?>
            		
            		<?=$form->field($model, 'site_qq_1')->textInput(['value'=>$value['site_qq_1']])?>
            		
            		<?=$form->field($model, 'site_qq_2')->textInput(['value'=>$value['site_qq_2']])?>
            		
            		<?=$form->field($model, 'site_qq_3')->textInput(['value'=>$value['site_qq_3']])?>
                
                </div>
                <div role="tabpanel" class="tab-pane" id="smtp">
                	
                	<?=$form->field($model, 'smtp_server')->textInput(['value'=>$value['smtp_server']])?>
                		
            		<?=$form->field($model, 'smtp_port')->textInput(['value'=>$value['smtp_port']])?>
            		
            		<?=$form->field($model, 'smtp_user')->textInput(['value'=>$value['smtp_user']])?>
            		
            		<?=$form->field($model, 'smtp_pass')->passwordInput(['value'=>$value['smtp_pass']])?>
                
                </div> 
        	</div>
    	<button class="btn btn-success pull-left" type="submit"><i class="fa fa-save"></i> 保存</button>
   <?php ActiveForm::end();?>
    </div>

  </div>
</div>
