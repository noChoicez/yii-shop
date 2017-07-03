<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsBrandModel */

$this->title = '添加品牌';
$this->params['breadcrumbs'][] = ['label' => '商品管理','url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '品牌列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-brand-model-create">
	<div class="box">
        <div class="box-header with-border">
          <div class="box-title">添加品牌</div>
        </div>
        <div class="box-body">

		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>

		</div>
	</div>
</div>
