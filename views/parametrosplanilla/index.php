

<?php

use yii\helpers\Html;
use yii\grid\GridView;
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

$urlperview = '../parametrosplanilla/view';
$usuario = $_SESSION['user'];


// VALIDACION DE PERMISOS VIEW
    $permisosview = "select  menudetalle.DescripcionMenuDetalle as 'DETALLE', menuusuario.MenuUsuarioActivo as 'ACTIVO', menudetalle.Url as 'URL' from menuusuario
            inner join MenuDetalle on menuusuario.IdMenuDetalle = menudetalle.IdMenuDetalle
            inner join menu on menuusuario.IdMenu = menu.IdMenu
            inner join usuario on menuusuario.IdUsuario = usuario.IdUsuario
            where usuario.InicioSesion = '" . $usuario . "' and TipoPermiso = 2 and menudetalle.Url = '" . $urlperview . "'";

    $resultadopermisosview = $mysqli->query($permisosview);

    while ($resview = $resultadopermisosview->fetch_assoc())
               {
                   $urlview = $resview['URL'];
                   $activoview = $resview['ACTIVO'];
               }

    if($urlperview == $urlview and $activoview == 1){
        $view = '{view}';
    }
    else{
      $view = '';
    }
/* @var $this yii\web\View */
/* @var $searchModel app\models\ParametrosplanillaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte de Planilla';
$this->params['breadcrumbs'][] = $this->title;
?>

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
<!--
                         <?php  echo $this->render('_search', ['model' => $searchModel]); ?> -->

                        <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                  'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    //'IdParametroPlanilla',
                                'FechaCreacion',
                                'MesPlanilla',
                                'PeriodoPlanilla',
                                'QuincenaPlanilla',

                                    ['class' => 'yii\grid\ActionColumn', 'options' => ['style' => 'width:115px;'], 'template' => "{report} {view}"],
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
