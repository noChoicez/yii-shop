<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GoodsTypeModel;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品规格';
$this->params['breadcrumbs'][] = ['label' => '商品管理','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-spec-model-index">
      <div class="box">
        <div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>

        <div class="box-body">

            <p>
                <?= Html::a('添加规格', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
            </p>

            <?= GridView::widget([
            	'tableOptions' => ['class'=>'table table-bordered table-hover'],
                'dataProvider' => $dataProvider,
            	'summary'=>false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'spec_name',
                    [
                        'attribute'=>'type_id',
                        'value' =>function($model){
                            return GoodsTypeModel::getGoodsType($model->type_id);
                        },
                    ],
                    [
                        'attribute'=>'spec_index',
                        'value' => function ($model){
                            return ($model->spec_index == 1)?'是':'否';
                        }
                    ],
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
