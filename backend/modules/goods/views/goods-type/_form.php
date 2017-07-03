<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsTypeModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-type-model-form">

    <?php $form = ActiveForm::begin([
    	'fieldConfig' => [
            'template' => '<div class="row"><div class="col-sm-2">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <button class="btn btn-primary btn-flat" type="submit">保存</button>

    <?php ActiveForm::end(); ?>

</div>
