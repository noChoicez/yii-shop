<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\PromoCouponModel;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PromoCouponSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '优惠券';
$this->params['breadcrumbs'][] = ['label' => '促销管理','url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-coupon-model-index">
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title"><?= Html::encode($this->title) ?></div>
		</div>
		<div class="box-body">
			
			<?= $this->render('_search', ['model' => $searchModel]); ?>
			
			<?= GridView::widget([
				'tableOptions' => ['class'=>'table table-bordered table-hover'],
		        'dataProvider' => $dataProvider,
		        //'filterModel' => $searchModel,
		        'summary' => false,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		
		            'id',
		            'name',
		            'desc:ntext',
		        	[
		        		'attribute' => 'type',
		        		'value' => function ($model) {
		        			return PromoCouponModel::type($model->type);
						},
					],
		            'create_time:date',
		
		            [
		            	'class' => 'yii\grid\ActionColumn',
		            	'header' => '操作',
		            ],
		        ],
		    ]); ?>	
		</div>
	</div>    
</div>
