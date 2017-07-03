<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdminModel */

$this->title = '添加管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-title"><i class="fa fa-list"></i> 添加管理员</div>
	</div>
	<div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
