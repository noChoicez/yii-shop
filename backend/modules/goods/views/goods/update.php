<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsModel */

$this->title = '更新商品';
$this->params['breadcrumbs'][] = ['label' => '商品管理','url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-model-update">
    <div class="box">
        <div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>
        <div class="box-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>
</div>
