<?php

use yii\helpers\Url;
use yii\helpers\Html;
//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '插件列表';
$this->params['breadcrumbs'][] = ['label' => '插件工具', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-model-index">
	<div class="box">
		<div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>
        <div class="box-body">
        
        	<div class="form-group" >
		        <?= Html::a('添加插件', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
		    </div>
        	
        	<ul class="nav nav-tabs" role="tablist" style="margin-bottom:20px;">
        		<?php foreach($group as $k => $v):?>
        			<li role="presentation" class=" <?php echo ($k == "payment")?"active":""?>">
				        <a href="#<?=$k?>" aria-controls="<?=$k?>" role="tab" data-toggle="tab"><?=Yii::t('common', $k)?></a>
				    </li>
				<?php endforeach;?>
			</ul>
			
			<div class="tab-content">
				<?php foreach($group as $k => $v):?>
					<div role="tabpanel" class="tab-pane fade in <?php echo ($k == "payment")?"active":""?>" id="<?=$k?>">
						<div class="row">
							<?php foreach($v as $kk => $vv):?>
							<div class="col-sm-3">
								<div class="thumbnail">
									<img src="<?=$vv['cover_image']?:'/statics/images/default.jpg'?>">
									<div class="caption">
										<h4><?=$vv['name']?></h4>
										<p><?=$vv['desc']?></p>
										<p>
											<a href="<?=Url::to([($k == "shipping")?'shipping':'config','id'=>$vv['id']])?>" class="btn btn-primary btn-flat">配置</a>
											<a href="<?=Url::to(['update','id'=>$vv['id']])?>" class="btn btn-primary btn-flat">编辑</a>
											<a class="btn btn-danger btn-flat" onclick="install(this)" data-id="<?=$vv['id']?>"><?=$vv['status']?"卸载":"安装"?></a>
										</p>
									</div>
								</div>
							</div>
							<?php endforeach;?>
						</div>
					</div>
				<?php endforeach;?>
        	</div>
        	
	        <?php /* echo GridView::widget([
		        'dataProvider' => $dataProvider,
		        'columns' => [
		            ['class' => 'yii\grid\SerialColumn'],
		
		            'id',
		            'type',
		            'name',
		            'code',
		            'author',
		            'version',
		            // 'desc',
		            // 'cover_image',
		            // 'back_image',
		            // 'config:ntext',
		            // 'config_value:ntext',
		
		            ['class' => 'yii\grid\ActionColumn'],
		        ],
		    ]); */  ?>
		    
        </div>
    </div>
</div>

<script>
/**
 * 安装，卸载
 */
function install(obj){
	add_class(obj, "disabled")
	$.ajax({
		url:"<?=Url::to(['ajax'])?>",
		data:{id:obj.dataset.id,action:"install"},
		type:"post",
		success:function(res){
			res = JSON.parse(res);
			res.status?((obj.innerHTML == "卸载")?(obj.innerHTML = "安装"):(obj.innerHTML = "卸载")):""
			remove_class(obj, "disabled")
			layer.msg(res.msg, {time: 1000});
		},
		error:function(err){}	
	})
}
</script>
