<?php
// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }
$usuario = $_SESSION['user'];
 $urlperdelete = '../planillamoviemiento/delete';


 // VALIDACION DE PERMISOS DELETE
     $permisosdelete = "select  menudetalle.DescripcionMenuDetalle as 'DETALLE', menuusuario.MenuUsuarioActivo as 'ACTIVO', menudetalle.Url as 'URL' from menuusuario
             inner join MenuDetalle on menuusuario.IdMenuDetalle = menudetalle.IdMenuDetalle
             inner join menu on menuusuario.IdMenu = menu.IdMenu
             inner join usuario on menuusuario.IdUsuario = usuario.IdUsuario
             where usuario.InicioSesion = '" . $usuario . "' and TipoPermiso = 2 and menudetalle.Url = '" . $urlperdelete . "'";

     $resultadopermisosdelete = $mysqli->query($permisosdelete);

     while ($resdelete = $resultadopermisosdelete->fetch_assoc())
                {
                    $urldelete = $resdelete['URL'];
                    $activodelete = $resdelete['ACTIVO'];
                }

      if($urlperdelete == $urldelete and $activodelete == 1){
          $delete = '{delete}';
      }
      else{
        $delete = '';
      }

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanillamovimientoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resumen de Planilla';
$this->params['breadcrumbs'][] = $this->title;
?>

<div align="right">
   <!-- <?= Html::a('Ingresar Planilla', ['create'], ['class' => 'btn btn-success']) ?> -->
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="orange">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                  <h4 class="card-title"><?= Html::encode($this->title) ?> </h4>
                  <div class="toolbar">
                    </div>
                    <div class="table-responsive">
                        <table class="table">

                                                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

                                                        <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                // 'filterModel' => $searchModel,
                                    'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                  //'IdPlanilla',
                                  [
                                     'attribute'=>'IdEmpleado',
                                     'value'=>'idEmpleado.fullname',
                                   ],
                                  'FechaTransaccion',
                                  [
                                    'attribute' => 'ISRPlanilla',
                                    'value' => function ($model) {
                                        return '$' . ' ' . $model->ISRPlanilla;
                                    }
                                 ] ,
                                 [
                                   'attribute' => 'AFPPlanilla',
                                   'value' => function ($model) {
                                       return '$' . ' ' . $model->AFPPlanilla;
                                   }
                                ] ,
                                [
                                  'attribute' => 'ISSSPlanilla',
                                  'value' => function ($model) {
                                      return '$' . ' ' . $model->ISSSPlanilla;
                                  }
                               ] ,
                               [
                                 'attribute' => 'Honorario',
                                 'value' => function ($model) {
                                     return '$' . ' ' . $model->Honorario;
                                 }
                              ] ,
                              [
                                'attribute' => 'Comision',
                                'value' => function ($model) {
                                    return '$' . ' ' . $model->Comision;
                                }
                             ] ,
                             [
                               'attribute' => 'Bono',
                               'value' => function ($model) {
                                   return '$' . ' ' . $model->Bono;
                               }
                            ] ,
                            [
                              'attribute' => 'Anticipos',
                              'value' => function ($model) {
                                  return '$' . ' ' . $model->Anticipos;
                              }
                           ] ,
                           [
                             'attribute' => 'HorasExtras',
                             'value' => function ($model) {
                                 return '$' . ' ' . $model->HorasExtras;
                             }
                          ] ,
                          [
                            'attribute' => 'Vacaciones',
                            'value' => function ($model) {
                                return '$' . ' ' . $model->Vacaciones;
                            }
                         ] ,
                         [
                           'attribute' => 'Incapacidades',
                           'value' => function ($model) {
                               return '$' . ' ' . $model->Incapacidades;
                           }
                        ] ,
                        [
                          'attribute' => 'Permisos',
                          'value' => function ($model) {
                              return '$' . ' ' . $model->Permisos;
                          }
                       ] ,
                                  'MesPlanilla',
                                  'AnioPlanilla',

                                          ['class' => 'yii\grid\ActionColumn', 'options' => ['style' => 'width:50px;'], 'template' => "$delete"],
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
