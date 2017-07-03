<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\GoodsCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-category-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    	'options'=>['class' => 'form-inline'],
    	'fieldConfig' => [
			'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal','margin-right'=>'5px']],
    		'inputOptions' => ['class'=>'form-control','style'=>['margin-right'=>'5px']],
    	],
    ]); ?>

    <?= $form->field($model, 'cat_name') ?>

    <?= $form->field($model, 'is_show')->dropDownList([''=>'全部',0=>'隐藏',1=>'显示']) ?>

    <div class="form-group" style="padding-bottom: 12px;">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-info btn-flat']) ?>
        <?php //echo Html::resetButton('Reset', ['class' => 'btn btn-default btn-flat']) ?>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
