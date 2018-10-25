<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReporteseppSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte SEPP';
$this->params['breadcrumbs'][] = $this->title;
?>

<div align="right">
   <?= Html::a('Ver Reporte', ['filter'], ['class' => 'btn btn-info']) ?>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="orange">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                  <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
                  <div class="toolbar">
                    </div>
                    <div class="table-responsive">
                        <table class="table">

                <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    // 'IdReporteSepp',
                                    // 'IdEmpleado',
                                    'CodigoSepp',
                                    //'PlanillaCodigoObservacion',
                                    'PlanillaIngresoBaseCotizacion',
                                    // 'PlanillaHorasJornadaLaboral',
                                    // 'PlanillaDiasCotizados',
                                    // 'PlanillaCotizacionVoluntariaAfiliado',
                                    // 'PlanillaCotizacionVoluntariaEmpleador',
                                    'Nup',
                                    'InstitucionPrevisional',
                                    'PrimerNombre',
                                    'SegundoNombre',
                                    'PrimerApellido',
                                    'SegundoApellido',
                                    'ApellidoCasada',
                                    // 'TipoDocumento',
                                    // 'NumeroDocumento',
                                    'Periodo',
                                    'Mes',

                                      ['class' => 'yii\grid\ActionColumn', 'options' => ['style' => 'width:75px;'], 'template' => " {update} {delete}"],
                                ],
                            ]); ?>
                                              </table>
                    </div>
                </div>
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
                    <!-- end row -->
