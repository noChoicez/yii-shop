<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GoodsTypeModel;
use common\models\GoodsAttributeModel;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsAttributeModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-attribute-model-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<div class="row"><div class="col-sm-2">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>

    <?= $form->field($model, 'type_id')->dropDownList(GoodsTypeModel::getGoodsType()) ?>

    <?= $form->field($model, 'attr_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attr_index')->dropDownList(GoodsAttributeModel::getAttrIndex()) ?>

    <?= $form->field($model, 'attr_input_type')->dropDownList(GoodsAttributeModel::getInputType()) ?>

    <?= $form->field($model, 'attr_values')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>

    <button class="btn btn-primary btn-flat" type="submit"><i class="fa fa-save"></i> 保存</button>

    <?php ActiveForm::end(); ?>

</div>
