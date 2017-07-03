<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PostsCategoryModel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts Category Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-category-model-view">

    <div class="box">
		<div class="box-header with-border">
			<div class="box-title"><?= Html::encode($this->title) ?></div>
		</div>
		<div class="box-body">
			<p>
		        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
		            'class' => 'btn btn-danger',
		            'data' => [
		                'confirm' => 'Are you sure you want to delete this item?',
		                'method' => 'post',
		            ],
		        ]) ?>
		    </p>
		
		    <?= DetailView::widget([
		        'model' => $model,
		        'attributes' => [
		            'id',
		            'level',
		            'parent_id',
		            'cat_name',
		            'cat_desc',
		            'cat_path',
		            'order',
		        ],
		    ]) ?>
		</div>
	</div>

    

</div>
