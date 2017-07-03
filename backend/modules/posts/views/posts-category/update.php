<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PostsCategoryModel */

$this->title = '更新分类';
$this->params['breadcrumbs'][] = ['label' => '内容管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '文章 分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-category-model-update">

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
