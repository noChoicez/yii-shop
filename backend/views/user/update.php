<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserModel */

$this->title = '更新用户: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新用户';
?>

<div class="box">
	<div class="box-header with-border">
	  <div class="box-title"> 更新用户</div>
	</div>
	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
