<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-model-index">
	<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-title"><i class="fa fa-list"></i> 管理员列表</div>
	</div>
	<div class="panel-body">

    <p>
        <?= Html::a('添加管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            // 'email_validate_token:email',
            // 'avatar',
            // 'vip_level',
            [
                'attribute' => 'status',
                'value'=>function($model){
                    return ($model->status == 0)?'未激活':'已激活';
                },
                'filter' => ['0'=>'未激活','10'=>'已激活'],
            ],
            [
                'attribute'=>'created_at',
                'value'=>function ($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{assignment} {update} {delete} {resetpwd}',
                'buttons' =>[
                    'assignment' => function ($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['admin/assignment/view','id'=>$model->id]), ['title' => '权限分配']);
                    },
                    'resetpwd' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-wrench"></span>', $url, ['title' => '重置密码'] );
                    },
                ],
            ],
        ],
    ]); ?>
    </div>
  </div>
</div>
