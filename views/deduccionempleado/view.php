<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Deduccionempleado */

$this->title = $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Deduccion Empleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deduccionempleado-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdDeduccionEmpleado], ['class' => 'btn btn-z']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'IdDeduccionEmpleado',
            'idEmpleado.fullname',
                                                   [
       'attribute' => 'SueldoEmpleado',
       'value' => function ($model) {
           return '$' . ' ' . $model->SueldoEmpleado;
       }
    ] ,
                                           [
       'attribute' => 'DeducAfp',
       'value' => function ($model) {
           return '$' . ' ' . $model->DeducAfp;
       }
    ] ,
                                           [
       'attribute' => 'DeducIsss',
       'value' => function ($model) {
           return '$' . ' ' . $model->DeducIsss;
       }
    ] ,
                                           [
       'attribute' => 'DeducIsr',
       'value' => function ($model) {
           return '$' . ' ' . $model->DeducIsr;
       }
    ] ,
                                           [
       'attribute' => 'DeducIpsfa',
       'value' => function ($model) {
           return '$' . ' ' . $model->DeducIpsfa;
       }
    ] ,
                                           [
       'attribute' => 'SueldoNeto',
       'value' => function ($model) {
           return '$' . ' ' . $model->SueldoNeto;
       }
    ] ,
            'FechaCalculo',
        ],
    ]) ?>

</div>
