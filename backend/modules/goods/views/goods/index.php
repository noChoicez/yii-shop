<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品列表';
$this->params['breadcrumbs'][] = ['label' => '商品管理','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-model-index">
	<div class="box">
		<div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>
        <div class="box-body">
			
			<?= $this->render('_search', [
		        'model' => $searchModel,
		    ]) ?>

            <?= GridView::widget([
            	'tableOptions' => ['class'=>'table table-bordered table-hover'],
                'dataProvider' => $dataProvider,
                'summary' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'cat_id',
                    'brand_id',
                    'goods_name',
                    'goods_image',
                    // 'goods_number',
                    // 'goods_keyword',
                    // 'goods_desc:ntext',
                    // 'goods_remark',
                    // 'goods_weight',
                    // 'market_price',
                    // 'shop_price',
                    // 'cost_price',
                    // 'stock_count',
                    // 'comment_count',
                    // 'click_count',
                    // 'collect_count',
                    // 'sale_count',
                    // 'create_time',
                    // 'update_time',
                    // 'is_free_shipping',
                    // 'is_new',
                    // 'is_hot',
                    // 'is_sale',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                    ],
                ],
            ]); ?>

        </div>
    </div>
</div>

