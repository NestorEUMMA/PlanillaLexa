<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramoisr */

$this->title = $model->NumTramo;
$this->params['breadcrumbs'][] = ['label' => 'Tramo ISR', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramoisr-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdTramoIsr], ['class' => 'btn btn-z']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdTramoIsr',
            'NumTramo',
            [
       'attribute' => 'TramoDesde',
       'value' => function ($model) {
           return '$' . ' ' . $model->TramoDesde;
       }
    ] ,
    [
       'attribute' => 'TramoHasta',
       'value' => function ($model) {
           return '$' . ' ' . $model->TramoHasta;
       }
    ] ,
    [
       'attribute' => 'TramoAplicarPorcen',
       'value' => function ($model) {
           return '%' . ' ' . $model->TramoAplicarPorcen;
       }
    ] ,
                 [
       'attribute' => 'TramoExceso',
       'value' => function ($model) {
           return '$' . ' ' . $model->TramoExceso;
       }
    ] ,
         [
       'attribute' => 'TramoCuota',
       'value' => function ($model) {
           return '$' . ' ' . $model->TramoCuota;
       }
    ] ,
         [
       'attribute' => 'TramoFormaPago',
       'value' => function ($model) {
           return '$' . ' ' . $model->TramoFormaPago;
       }
    ] ,

        ],
    ]) ?>

</div>
