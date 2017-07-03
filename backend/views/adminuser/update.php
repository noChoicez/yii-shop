<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminModel */

$this->title = '更新管理员: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-title"><i class="fa fa-list"></i> 更新管理员</div>
	</div>
	<div class="panel-body">

    <?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => '<div class="row"><div class="col-lg-1">{label}</div><div class="col-lg-11"><div class="col-lg-8">{input}</div><div>{error}</div></div></div>',
    ],  
    ]); ?>
	
	<?= $form->field($model, 'username')->textInput() ?>
	
	<?= $form->field($model, 'email')->textInput() ?>
	
    <?= $form->field($model, 'status')->dropDownList($model::status()) ?>

    <div class="form-group">
        <?= Html::submitButton('更新', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	</div>
</div>
