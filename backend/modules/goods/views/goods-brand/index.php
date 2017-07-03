<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\GoodsCategoryModel;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GoodsBrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '品牌列表';
$this->params['breadcrumbs'][] = ['label' => '商品管理','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-brand-model-index">
    <div class="box">
        <div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>
        <div class="box-body">
			
			<?= $this->render('_search', [
		        'model' => $searchModel,
		    ]) ?>

            <?php Pjax::begin();
            echo GridView::widget([
            	'tableOptions' => ['class'=>'table table-bordered table-hover'],
                'dataProvider' => $dataProvider,
                'summary' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'name',
                    [
                        'attribute' => 'cat_id',
                        'value' => function ($model) {
                            return GoodsCategoryModel::getCatName($model->cat_id);
                        }
                    ],
                    'url:url',
                    [
                        'format' => 'raw',
                        'attribute' => 'logo',
                        'value' => function ($model) {
                            return $model->logo?'<a target="_blank" href="'.$model->logo.'"><i class="fa fa-image"></i></a>':'暂无图片';
                        }
                    ],
                    // 'desc',
                    // 'order',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'headerOptions' => ['width' => '80'],
                        'template' => '{update} {delete}',
                        
                    ],
                ],
            ]); 
            Pjax::end();
            ?>
        </div>
    </div>

</div>
