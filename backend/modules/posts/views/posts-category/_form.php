<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PostsCategoryModel;

header("content-type:text/html;charset=utf-8");
//d(PostsCategoryModel::getPostsCategory());
//die;
/* @var $this yii\web\View */
/* @var $model common\models\PostsCategoryModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-category-model-form">

    <?php $form = ActiveForm::begin([
    	'options'=>['enctype'=>'multipart/form-data'],
        'fieldConfig' => [
            'template' => '<div class="row"><div class="col-sm-2 max-width-120">{label}：</div><div class="col-sm-10"><div class="row"><div class="col-sm-8">{input}</div><div>{error}</div></div></div></div>',
            'labelOptions' => ['style'=>['border'=>'none','padding'=>'6px 0','font-weight'=>'normal']], 
        ],
    ]); ?>

    <?= $form->field($model, 'parent_id')->dropDownList(PostsCategoryModel::getPostsCategory(),['prompt' => '请选择']) ?>

    <?= $form->field($model, 'cat_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cat_desc')->textarea(['maxlength' => true]) ?>

	<?= $form->field($model, 'is_show')->dropDownList([1=>'是',0=>'否']) ?>
	
    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
