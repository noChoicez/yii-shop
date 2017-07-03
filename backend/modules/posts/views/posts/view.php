<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PostsModel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-model-view">
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
		            'cat_id',
		            'posts_title',
		            'posts_image',
		            'posts_keyword',
		            'posts_link:ntext',
		            'posts_desc',
		            'posts_content:ntext',
		            'create_time',
		            'is_show',
		            'is_open',
		        ],
		    ]) ?>	
		</div>
	</div>

   

</div>
