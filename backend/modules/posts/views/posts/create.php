<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PostsModel */

$this->title = '添加文章';
$this->params['breadcrumbs'][] = ['label' => '内容管理','url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '文章列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-model-create">
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
