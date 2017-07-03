<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\UserModel */
/* @var $form yii\widgets\ActiveForm */
?>
	  
<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => '<div class="row"><div class="col-sm-2 col-md-2 col-lg-1">{label}</div><div class="col-sm-10 col-md-10 col-lg-11"><div class="col-sm-8">{input}</div><div>{error}</div></div></div>',
        'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0']],
    ],  
]); ?>

<?= $form->field($model, 'username')->textInput() ?>

<?= $form->field($model, 'email')->textInput() ?>

<?= $form->field($model, 'vip_level')->textInput() ?>

<?= $form->field($model, 'status')->dropDownList($model::status()) ?>

<?= $form->field($model, 'updated_at')->textInput(['value'=>date('Y-m-d H:i:s',$model->updated_at),'disabled'=>true]) ?>

<?= $form->field($model, 'created_at')->textInput(['value'=>date('Y-m-d H:i:s',$model->created_at),'disabled'=>true]) ?>

<div class="form-group">
    <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-flat']) ?>
</div>
<?php ActiveForm::end(); ?>

