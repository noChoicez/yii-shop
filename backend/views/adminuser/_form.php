<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AdminModel;

/* @var $this yii\web\View */
/* @var $model common\models\AdminModel */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => '<div class="row"><div class="col-lg-1">{label}</div><div class="col-lg-11"><div class="col-lg-8">{input}</div><div>{error}</div></div></div>',
    ],  
]); ?>

<?= $form->field($model, 'username')->textInput() ?>

<?= $form->field($model, 'email')->textInput() ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'repassword')->passwordInput() ?>

<?= $form->field($model, 'status')->dropDownList(AdminModel::status()) ?>

<div class="form-group">
    <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-flat']) ?>
</div>

<?php ActiveForm::end(); ?>


