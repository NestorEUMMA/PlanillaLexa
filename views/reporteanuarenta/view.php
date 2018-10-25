<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rptrentaanual */

$this->title = $model->Idrptrentaanual;
$this->params['breadcrumbs'][] = ['label' => 'Reporte F910', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rptrentaanual-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->Idrptrentaanual], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'Descripcion',
            'idEmpleado.fullname',
            'Nit',
            'CodigoIngreso',
            'MontoDevengado',
            'ImpuestoRetenido',
            'AguinaldoExento',
            'AguinaldoGravado',
            'Isss',
            'Afp',
            'Ipsfa',
            'BienestarMagisterial',
            'Anio',
            'Mes',
            'FechaCreacion',
            'Quincena',
        ],
    ]) ?>

</div>
