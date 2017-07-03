<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GoodsTypeModel;
use common\models\GoodsAttributeModel;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GoodsAttributeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品属性';
$this->params['breadcrumbs'][] = ['label' => '商品管理','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-attribute-model-index">
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
                    [
                        'attribute'=>'type_id',
                        'value' => function ($model){
                            return GoodsTypeModel::getGoodsType($model->type_id);
                        },
                    ],
                    'attr_name',
                    [
                        'attribute'=>'attr_index',
                        'value'=>function ($model){
                            return GoodsAttributeModel::getAttrIndex($model->attr_index);
                        },
                    ],
                    [
                        'attribute'=>'attr_input_type',
                        'value'=>function ($model){
                            return GoodsAttributeModel::getInputType($model->attr_input_type);
                        },
                    ],
                    // 'attr_values:ntext',
                    'order',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'headerOptions' => ['width' => '80'],
                        'template' => '{update} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
