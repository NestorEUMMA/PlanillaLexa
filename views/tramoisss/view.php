<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramoisss */

$this->title = $model->TramoIsss;
$this->params['breadcrumbs'][] = ['label' => 'Tramo ISSS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramoisss-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdTramoIsss], ['class' => 'btn btn-z']) ?>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
       'attribute' => 'TramoIsss',
       'value' => function ($model) {
           return '%' . ' ' . $model->TramoIsss;
       }
    ] ,
    [
       'attribute' => 'TechoIsss',
       'value' => function ($model) {
           return '$' . ' ' . $model->TechoIsss;
       }
    ] ,
    [
       'attribute' => 'TechoSig',
       'value' => function ($model) {
           return '$' . ' ' . $model->TechoSig;
       }
    ] ,
        ],
    ]) ?>

</div>
