<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PluginModel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Plugin Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'name',
            'code',
            'author',
            'version',
            'desc',
            'cover_image',
            'back_image',
            'config:ntext',
            'config_value:ntext',
        ],
    ]) ?>

</div>
