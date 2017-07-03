<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PromoCouponModel */

$this->title = '更新优惠券';
$this->params['breadcrumbs'][] = ['label' => '促销管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '优惠券', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-coupon-model-update">

    <div class="box">
		<div class="box-header with-border">
			<div class="box-title"><?= Html::encode($this->title) ?></div>
		</div>
		<div class="box-body">
			
			 <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
			
		</div>
	</div>

</div>
