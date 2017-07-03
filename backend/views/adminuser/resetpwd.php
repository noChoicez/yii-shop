<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminModel */

$this->title = '重置密码';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-title"><i class="fa fa-list"></i> 重置密码</div>
	</div>
	<div class="panel-body">

   	<?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<div class="row"><div class="col-lg-1">{label}</div><div class="col-lg-11"><div class="col-lg-8">{input}</div><div>{error}</div></div></div>',
        ],  
    ]); ?>
    
    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <?= $form->field($model, 'repassword')->passwordInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
   
    </div>
</div>
