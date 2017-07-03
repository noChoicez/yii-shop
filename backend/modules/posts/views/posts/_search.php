<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\PostsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    	'options'=>['class' => 'form-inline'],
    	'fieldConfig' => [
    		'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal','margin-right'=>'5px']],
    		'inputOptions' => ['class'=>'form-control','style'=>['margin-right'=>'5px']],
    	],
    ]); ?>

    <?= $form->field($model, 'posts_title') ?>

    <?php // echo $form->field($model, 'posts_link') ?>

    <?php // echo $form->field($model, 'posts_desc') ?>

    <?php // echo $form->field($model, 'posts_content') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'is_show') ?>

    <?php // echo $form->field($model, 'is_open') ?>

    <div class="form-group" style="padding-bottom:12px;">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-info btn-flat']) ?>
        <?php // echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('添加文章', ['create'], ['class' => 'btn btn-info btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
