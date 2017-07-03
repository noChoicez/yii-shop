<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品类型';
$this->params['breadcrumbs'][] = ['label' => '商品管理','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-type-model-index">
   <div class="box">
        <div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>
        <div class="box-body">

		<div class="form-group">
			<?= Html::a('添加类型', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
		</div>
            

        <?= GridView::widget([
        	'tableOptions' => ['class'=>'table table-bordered table-hover'],
            'dataProvider' => $dataProvider,
        	'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                [
                    'attribute' => 'name',
                ],
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
