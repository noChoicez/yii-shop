<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\UserModel;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = ['label'=>'用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">
  <div class="box">
	<div class="box-header with-border">
	  <div class="box-title"> 用户列表</div>
	</div>
	<div class="box-body">
    
        <div class="user-model-search">

            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options'=>['class' => 'form-inline'],
                'fieldConfig' => [
                    'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal','margin-right'=>'5px']],
                    'inputOptions' => ['class'=>'form-control','style'=>['margin-right'=>'5px']],
                ], 
            ]); ?>

            <?php //echo $form->field($searchModel, 'id') ?>

            <?= $form->field($searchModel, 'username') ?>

            <?= $form->field($searchModel, 'email') ?>
            
            <div class="form-group" style="padding-bottom: 12px;">
            <button type="submit" class="btn btn-block btn-info btn-flat">搜索</button>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    <?= GridView::widget([
        'tableOptions' => ['class'=>'table table-bordered table-hover'],
        'summary'=>'',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],          
            [
                'attribute'=>'id',
            ],
            'username',
            'email:email',
            [
                'attribute'=>'vip_level',
                //'headerOptions'=>['width'=>30],
            ],
            [
                'attribute' => 'status',
                'value' => function ($model){return ($model->status == 0)?'未激活':'已激活';},
                'filter'=>['0'=>'未激活','10'=>'已激活'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            
            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                'template' => '{update} {delete} {active}',
                'buttons' => [
                    'active' => function ($url, $model, $key) {
                        if($model->status == 10){
                            return  Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, ['title' => '禁用'] ) ;
                        }else{
                            return  Html::a('<span class="glyphicon glyphicon-saved"></span>', $url, ['title' => '激活'] ) ;
                        }
                        
                     },
                    
                ],
               //'headerOptions' => ['width' => '180']
            ],
            
        ],
    ]); ?>
  	</div>  
  </div>
</div>
