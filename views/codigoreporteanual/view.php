<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Codigoreporteanual */

$this->title = $model->CodigoIngreso;
$this->params['breadcrumbs'][] = ['label' => 'Codigo de Ingreso', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="codigoreporteanual-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->CodigoIngreso], ['class' => 'btn btn-z']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CodigoIngreso',
            'Descripcion',
        ],
    ]) ?>

</div>
