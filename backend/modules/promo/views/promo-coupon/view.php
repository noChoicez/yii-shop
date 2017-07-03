<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PromoCouponModel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '促销管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '优惠券', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-coupon-model-view">
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title"><?= Html::encode($this->title) ?></div>
		</div>
		<div class="box-body">
			<p>
		        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
		        <?= Html::a('删除', ['delete', 'id' => $model->id], [
		            'class' => 'btn btn-danger btn-flat',
		            'data' => [
		                'confirm' => '你确定删除此项吗?',
		                'method' => 'post',
		            ],
		        ]) ?>
		    </p>
		
		    <?= DetailView::widget([
		        'model' => $model,
		        'attributes' => [
		            'id',
		            'type',
		            'name',
		            'desc:ntext',
		            'range',
		            'create_num',
		            'send_num',
		            'use_num',
		            'send_type',
		            'send_start_time',
		            'send_end_time',
		            'use_start_time',
		            'use_end_time',
		            'create_time',
		        ],
		    ]) ?>
		</div>
	</div>
    <h1></h1>

    

</div>
