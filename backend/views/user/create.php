<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserModel */

$this->title = '添加用户';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
	<div class="box-header with-border">
	  <div class="box-title"> 添加用户</div>
	</div>
	<div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
    </div>
</div>


