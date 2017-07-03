<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PluginModel */

$this->title = '更新插件';
$this->params['breadcrumbs'][] = ['label' => '插件工具', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '插件列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-model-update">
	<div class="box">
        <div class="box-header with-border">
          <div class="box-title"><?=Html::encode($this->title)?></div>
        </div>
        <div class="box-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>
</div>
