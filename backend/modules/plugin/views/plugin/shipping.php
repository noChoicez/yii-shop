<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model common\models\PluginModel */

$this->title = '顺丰物流';
$this->params['breadcrumbs'][] = ['label' => '插件工具', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '插件列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '物流插件', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-model-config">
    <div class="box">
		<div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>
        <div class="box-body">
        	
        	<div class="form-group" >
		        <?= Html::a('添加地区', ['shipping-create','plugin_id'=>Yii::$app->request->get("id")], ['class' => 'btn btn-info btn-flat']) ?>
		    </div>
        	
        	<?php echo GridView::widget([
        		'tableOptions' => ['class'=>'table table-bordered table-hover'],
		        'dataProvider' => $dataProvider,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		
		            'id',
		        	'name',
		        	[
		        		'label' => '地区范围',
		        		'attribute' => 'shippingArea.area',
		        		'value' => function ($model){
		        			$str = '';
		        			foreach($model->shippingArea as $k => $v){
		        				$str .=$v->area->attributes['name'].',';
		        			}
		        			return (strlen(trim($str,',')) >= 80)?(mb_substr(trim($str,','), 0, 65, 'utf-8').'...'):trim($str,',');
        				},
        			],
		
		            [
		            	'class' => 'yii\grid\ActionColumn',		
		            	'header' => '操作',
						'template' => '{shipping-create} {shipping-delete}',
		            	'buttons' => [
		            		'shipping-create' =>  function ($url, $model, $key) {
                      			return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑'] ) ;
        					},
        					'shipping-delete' =>  function ($url, $model, $key) {
        						return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '编辑'] ) ;
        					}
        				],
        			],
		        ],
		    ]);  ?>

		    
		</div>
	</div>
</div>
