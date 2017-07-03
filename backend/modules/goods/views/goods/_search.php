<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GoodsBrandModel;

/* @var $this yii\web\View */
/* @var $model common\models\search\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-model-search">

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

    <?= $form->field($model, 'brand_id')->dropDownList(GoodsBrandModel::getGoodsBrand())  ?>

    <?= $form->field($model, 'goods_name') ?>

    <?php // echo $form->field($model, 'is_free_shipping') ?>

    <?php // echo $form->field($model, 'is_new') ?>

    <?php // echo $form->field($model, 'is_hot') ?>

    <?= $form->field($model, 'is_sale')->dropDownList([''=>'全部',0=>'下架',1=>'上架']) ?>

    <div class="form-group" style="padding-bottom: 12px;">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-info btn-flat']) ?>
        <?php // echo Html::resetButton('重置', ['class' => 'btn btn-info btn-flat']) ?>
        <?= Html::a('添加商品', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
