<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = ['label' => '内容管理','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-model-index">
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title"><?= Html::encode($this->title) ?></div>
		</div>
		<div class="box-body">
		
			<?= $this->render('_search', ['model' => $searchModel]); ?>
			
			<?= GridView::widget([
		        'tableOptions' => ['class'=>'table table-bordered table-hover'],
                'dataProvider' => $dataProvider,
                'summary' => false,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		
		            'id',
		            'cat_id',
		            'posts_title',
		            'posts_image',
		            'posts_keyword',
		            // 'posts_link:ntext',
		            // 'posts_desc',
		            // 'posts_content:ntext',
		            // 'create_time',
		            // 'is_show',
		            // 'is_open',
		
		            ['class' => 'yii\grid\ActionColumn'],
		        ],
		    ]); ?>
		    
		</div>
	</div>   
</div>
