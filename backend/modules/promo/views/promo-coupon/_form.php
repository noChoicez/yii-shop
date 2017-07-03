<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PromoCouponModel;

/* @var $this yii\web\View */
/* @var $model common\models\PromoCouponModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-coupon-model-form">

    <?php $form = ActiveForm::begin([
    	'options'=>['enctype'=>'multipart/form-data'],
        'fieldConfig' => [
            'template' => '<div class="row"><div class="col-sm-2 max-width-130">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'type')->dropDownList(PromoCouponModel::type(),['prompt' => '请选择']) ?>
	
	<?= $form->field($model, 'send_type')->dropDownList(PromoCouponModel::sendType(),['prompt' => '请选择']) ?>
	
    <?= $form->field($model, 'range')->dropDownList(PromoCouponModel::range(),['prompt' => '请选择']) ?>

    <?= $form->field($model, 'create_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'send_start_time')->textInput(['maxlength' => true, 'class'=>'form-control datepicker']) ?>

    <?= $form->field($model, 'send_end_time')->textInput(['maxlength' => true, 'class'=>'form-control datepicker']) ?>

    <?= $form->field($model, 'use_start_time')->textInput(['maxlength' => true, 'class'=>'form-control datepicker']) ?>

    <?= $form->field($model, 'use_end_time')->textInput(['maxlength' => true, 'class'=>'form-control datepicker']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

