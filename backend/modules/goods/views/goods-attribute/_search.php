<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GoodsTypeModel;
use common\models\GoodsAttributeModel;

/* @var $this yii\web\View */
/* @var $model common\models\search\GoodsAttributeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-attribute-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    	'options'=>['class' => 'form-inline'],
    	'fieldConfig' => [
    		'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal','margin-right'=>'5px']],
    		'inputOptions' => ['class'=>'form-control','style'=>['margin-right'=>'5px']],
    	],
    ]); ?>

    <?= $form->field($model, 'type_id')->dropDownList(GoodsTypeModel::getGoodsType()) ?>

    <?= $form->field($model, 'attr_name') ?>

    <?= $form->field($model, 'attr_index')->dropDownList(GoodsAttributeModel::getAttrIndex(),['prompt'=>'全部']) ?>

    <?= $form->field($model, 'attr_input_type')->dropDownList(GoodsAttributeModel::getInputType(),['prompt'=>'全部']) ?>

    <?php // echo $form->field($model, 'attr_values') ?>

    <?php // echo $form->field($model, 'order') ?>

    <div class="form-group" style="padding-bottom: 12px;">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-info btn-flat']) ?>
        <?php // echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('添加属性', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
