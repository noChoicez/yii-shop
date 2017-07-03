<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PromoCouponModel;

/* @var $this yii\web\View */
/* @var $model common\models\search\PromoCouponSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-coupon-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    	'options'=>['class' => 'form-inline'],
    	'fieldConfig' => [
    		'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal','margin-right'=>'5px']],
    		'inputOptions' => ['class'=>'form-control','style'=>['margin-right'=>'5px']],
    	],
    ]); ?>

    <?= $form->field($model, 'name') ?>
	
	<?= $form->field($model, 'type')->dropDownList(PromoCouponModel::type(),['prompt' => '请选择']) ?>
	
	<?= $form->field($model, 'send_type')->dropDownList(PromoCouponModel::sendType(),['prompt' => '请选择']) ?>

    <div class="form-group" style="padding-bottom:12px;">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-info btn-flat']) ?>
        <?php // echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('添加优惠券', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
