<?php

use yii\helpers\Html;
use yii\grid\GridView;
// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

 $urlperreport = '../anticipos/report';
 $urlperupdate = '../anticipos/update';
 $urlperview = '../anticipos/view';
 $urlpercreate = '../anticipos/create';
 $urlperdelete = '../anticipos/delete';
 $usuario = $_SESSION['user'];


// ************************************************************************
$permisosreport = "select  menudetalle.DescripcionMenuDetalle as 'DETALLE', menuusuario.MenuUsuarioActivo as 'ACTIVO', menudetalle.Url as 'URL' from menuusuario
        inner join MenuDetalle on menuusuario.IdMenuDetalle = menudetalle.IdMenuDetalle
        inner join menu on menuusuario.IdMenu = menu.IdMenu
        inner join usuario on menuusuario.IdUsuario = usuario.IdUsuario
        where usuario.InicioSesion = '" . $usuario . "' and TipoPermiso = 2 and menudetalle.Url = '" . $urlperreport . "'";

$resultadopermisosreport = $mysqli->query($permisosreport);

while ($resreport = $resultadopermisosreport->fetch_assoc())
           {
               $urlreport = $resreport['URL'];
               $activoreport = $resreport['ACTIVO'];
           }

if($urlperreport == $urlreport and $activoreport == 1){
    $report = '{report}';
}
else{
  $report = '';
}


// VALIDACION DE PERMISOS UPDATE
    $permisosupdate = "select  menudetalle.DescripcionMenuDetalle as 'DETALLE', menuusuario.MenuUsuarioActivo as 'ACTIVO', menudetalle.Url as 'URL' from menuusuario
            inner join MenuDetalle on menuusuario.IdMenuDetalle = menudetalle.IdMenuDetalle
            inner join menu on menuusuario.IdMenu = menu.IdMenu
            inner join usuario on menuusuario.IdUsuario = usuario.IdUsuario
            where usuario.InicioSesion = '" . $usuario . "' and TipoPermiso = 2 and menudetalle.Url = '" . $urlperupdate . "'";

    $resultadopermisosupdate = $mysqli->query($permisosupdate);

    while ($resupdate = $resultadopermisosupdate->fetch_assoc())
               {
                   $urlupdate = $resupdate['URL'];
                   $activoupdate = $resupdate['ACTIVO'];
               }

    if($urlperupdate == $urlupdate and $activoupdate == 1){
        $update = '{update}';
    }
    else{
      $update = '';
    }

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



// VALIDACION DE PERMISOS CREATE
    $permisoscreate = "select  menudetalle.DescripcionMenuDetalle as 'DETALLE', menuusuario.MenuUsuarioActivo as 'ACTIVO', menudetalle.Url as 'URL' from menuusuario
            inner join MenuDetalle on menuusuario.IdMenuDetalle = menudetalle.IdMenuDetalle
            inner join menu on menuusuario.IdMenu = menu.IdMenu
            inner join usuario on menuusuario.IdUsuario = usuario.IdUsuario
            where usuario.InicioSesion = '" . $usuario . "' and TipoPermiso = 2 and menudetalle.Url = '" . $urlpercreate . "'";

    $resultadopermisoscreate = $mysqli->query($permisoscreate);

    while ($rescreate = $resultadopermisoscreate->fetch_assoc())
               {
                   $urlcreate = $rescreate['URL'];
                   $activocreate = $rescreate['ACTIVO'];
               }



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
/* @var $this yii\web\View */
/* @var $searchModel app\models\Anticipossearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anticipos';
$this->params['breadcrumbs'][] = $this->title;

include '../include/dbconnect.php';

      $queryempleado = "select IdEmpleado, CONCAT(PrimerNomEmpleado,' ',SegunNomEmpleado,' ',PrimerApellEmpleado,' ',SegunApellEmpleado)  AS NombreCompleto from empleado where EmpleadoActivo = 1 order by NombreCompleto asc";
      $resultadoqueryempleado = $mysqli->query($queryempleado);
?>

<div align="right">

  <?php
      if($urlpercreate == $urlcreate and $activocreate == 1){
        ?>
        <button class="btn btn-success btn-raised " data-toggle="modal" data-target="#myModal">
                                              Nuevo Anticipo
         </button>
          <?php
      }
      else{
        $create = '';
      }
    ?>

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

                                                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

                            <p>

                            </p>

                              <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                 'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                      'attribute'=>'IdEmpleado',
                                      'value'=>'idEmpleado.fullname',
                                    ],
                                     'FechaAnticipos',
                                    'MesPeriodoAnticipo',
                                    'AnoPeriodoAnticipo',
                                     [
                                       'attribute' => 'MontoAnticipo',
                                       'value' => function ($model) {
                                           return '$' . ' ' . $model->MontoAnticipo;
                                       }
                                    ] ,
                                    ['class' => 'yii\grid\ActionColumn', 'options' => ['style' => 'width:210px;'], 'template' => " $view $update $delete $report"],

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
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <form action="../../views/anticipos/anticiposguardar.php" role="form" method="POST">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Anticipos a Empleado </h4>

                                                        </div>
                                                        <div class="modal-body">
                                                        <div class="form-group">
                                                          <label for="title">Seleccione un Empleado:</label>
                                                          <select name="Empleado" class="form-control">
                                                              <option value="">--- Seleccione un Empleado ---</option>
                                                              <?php
                                                                  while($row = $resultadoqueryempleado->fetch_assoc()){
                                                                      echo "<option value='".$row['IdEmpleado']."'>".$row['NombreCompleto']."</option>";
                                                                  }
                                                              ?>
                                                          </select>
                                                         </div>
                                                          <div class="form-group">
                                                              <label for="title">Monto Antncipo</label>
                                                              <input class="form-control" type="text" name="Anticipo" id="currency" />
                                                          </div>
                                                         <div class="form-group">
                                                              <label for="title">Fecha Anticipo</label>
                                                              <input name="Fecha" type="text" class="form-control datepicker"/>
                                                          </div>
                                                          <div class="modal-footer">
                                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                              <button type="submit" class="btn btn-success" name="guardarAnticipo" >Guardar Cambios</button>
                                                        </div>
                                                      </form>
                                                    </div>
                                                </div>
                                        </div>
      <script src="../../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
      <script type="text/javascript">
          $(document).ready(function(){

              demo.initFormExtendedDatetimepickers();

          });
      </script>

<script>
  $(function() {
    $('#currency').maskMoney();
  })
</script>
