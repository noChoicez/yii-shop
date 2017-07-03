<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsCategoryModel */

$this->title = '添加分类';
$this->params['breadcrumbs'][] = ['label' => '商品管理','url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '商品分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
