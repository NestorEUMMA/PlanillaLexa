<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rptsepp */

$this->title = 'SEPP';
$this->params['breadcrumbs'][] = ['label' => 'SEPP', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rptsepp-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdReporteSepp], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CodigoSepp',
            'PlanillaCodigoObservacion',
            'PlanillaIngresoBaseCotizacion',
            'PlanillaHorasJornadaLaboral',
            'PlanillaDiasCotizados',
            'PlanillaCotizacionVoluntariaAfiliado',
            'PlanillaCotizacionVoluntariaEmpleador',
            'Nup',
            'InstitucionPrevisional',
            'PrimerNombre',
            'SegundoNombre',
            'PrimerApellido',
            'SegundoApellido',
            'ApellidoCasada',
            'TipoDocumento',
            'NumeroDocumento',
            'Periodo',
            'Mes',
        ],
    ]) ?>

</div>
