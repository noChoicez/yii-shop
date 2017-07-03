<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PostsCategoryModel */

$this->title = '添加分类';
$this->params['breadcrumbs'][] = ['label' => '内容管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '文章分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-category-model-create">
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
