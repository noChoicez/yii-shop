<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\PostsCategoryModel;
use backend\modules\posts\controllers\PostsCategoryController;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PostsCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章分类';
$this->params['breadcrumbs'][] = ['label' => '内容管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-category-model-index">
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title"><?= Html::encode($this->title) ?></div>
		</div>
		<div class="box-body">
		
			<?= $this->render('_search', ['model' => $searchModel]); ?>
			
			<?= GridView::widget([
		        'tableOptions' => ['class'=>'table table-bordered table-hover'],
		        'dataProvider' => $dataProvider,
		        'rowOptions' => function ($model, $key, $index, $grid){
		            return ['data-parent'=>$model->parent_id,'style'=>['display'=>($model->level == 1)?'table-row':'none']];
		        },
		        'summary' => false,
		        'columns' => [
	        		[
		        		'class' => 'yii\grid\Column',
		        		'header' => '下级',
		        		'headerOptions' => ['width' => '50'],
		        		'content' => function ($model, $key, $index, $grid){
		        			return (PostsCategoryModel::hasChild($model->id))?PostsCategoryModel::getSpace($model->level).'<i onclick="open_tree(this)" style="cursor:pointer" class="fa fa-angle-double-right"></i>':'';
		        		},
	        		],
		            'id',
		            'level',
		            'parent_id',
		            [
		                'format' => 'html',
		                'attribute' => 'cat_name',
		                'value' => function ($model){
		                    return PostsCategoryModel::getSpace($model->level).$model->cat_name;
		                },
		            ],
		            'cat_desc',
		            'cat_path',
		            // 'order',
		
		            ['class' => 'yii\grid\ActionColumn'],
		        ],
		    ]); ?>
    
		</div>
	</div>    
</div>
<script type="text/javascript">
//获取所有子分类
function get_child(data, node, get_all = true)
{
    var child = document.querySelectorAll('[data-parent = "'+ node +'"]');
    if(child){
        child.forEach( i =>{
        	data.push(i)
        	if(get_all)
    			get_child(data, i.dataset.key, get_all)
        })	
    } 
}
//分类树打开、关闭
function open_tree(obj)
{
  var i_node = obj
  var obj = obj.parentNode.parentNode
  var node = obj.dataset.key
  var display = has_class(i_node,'fa-angle-double-right')?'display:table-row':'display:none'
  var data = []
  if(has_class(i_node,'fa-angle-double-right')){
    remove_class(i_node,'fa-angle-double-right')
    add_class(i_node,'fa-angle-double-down')
    get_child(data, node,false)
    var child = data
    for(var i = 0; i < child.length; i++){
      child[i].style = display
    }
  }else{
    remove_class(i_node,'fa-angle-double-down')
    add_class(i_node,'fa-angle-double-right')
    get_child(data, node)
    var child = data;
    for(var i = 0; i < child.length; i++){
      child[i].style = display
      if(child[i].getElementsByTagName('i')[0]){
        remove_class(child[i].getElementsByTagName('i')[0],'fa-angle-double-down')
        add_class(child[i].getElementsByTagName('i')[0],'fa-angle-double-right')
      } 
    }
  }
}
</script>
