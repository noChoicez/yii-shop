<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\GoodsBrandSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-brand-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    	'options'=>['class' => 'form-inline'],
    	'fieldConfig' => [
    		'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal','margin-right'=>'5px']],
    		'inputOptions' => ['class'=>'form-control','style'=>['margin-right'=>'5px']],
    	],
    ]); ?>

    <?php // echo $form->field($model, 'cat_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'order') ?>

    <div class="form-group" style="padding-bottom: 12px;">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-info btn-flat']) ?>
        <?php // echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('添加品牌', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
