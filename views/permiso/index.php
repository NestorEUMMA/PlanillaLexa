<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncapacidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

 $urlperupdate = '../permiso/update';
 $urlperview = '../permiso/view';
 $urlpercreate = '../permiso/create';
 $urlperdelete = '../permiso/delete';
 $usuario = $_SESSION['user'];


// ************************************************************************



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


      $queryempleado = "select IdEmpleado, CONCAT(PrimerNomEmpleado,' ',SegunNomEmpleado,' ',PrimerApellEmpleado,' ',SegunApellEmpleado)  AS NombreCompleto from empleado where EmpleadoActivo = 1 order by NombreCompleto asc";
      $resultadoqueryempleado = $mysqli->query($queryempleado);


/* @var $this yii\web\View */
/* @var $searchModel app\models\PermisoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permisos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div align="right">
  <?php
          if($urlpercreate == $urlcreate and $activocreate == 1){
            ?>
            <button class="btn btn-success btn-raised " data-toggle="modal" data-target="#myModal">
                                             Nueva Permiso
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
                              <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                     'attribute'=>'IdEmpleado',
                                     'value'=>'idEmpleado.fullname',
                                   ],
                                    'DiasPermiso',
                                    [
                                      'attribute' => 'SalarioDescuento',
                                      'value' => function ($model) {
                                          return '$' . ' ' . $model->SalarioDescuento;
                                      }
                                   ] ,
                                    'FechaPermiso',
                                    'PeriodoPermiso',
                                    'MesPermiso',
                                    'DescripcionPermiso',
                                    ['class' => 'yii\grid\ActionColumn', 'options' => ['style' => 'width:100px;'], 'template' => " $view  $delete "],
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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                   <div class="modal-dialog">
                                       <div class="modal-content">
                                         <form action="../../views/permiso/permisoguardar.php" role="form" method="POST">
                                           <div class="modal-header">
                                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                               <h4 class="modal-title">Permiso a Empleado</h4>

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
                                                 <label for="title">Dias</label>
                                                 <input class="form-control" type="text" name="Dias" />
                                             </div>
                                             <div class="form-group">
                                                 <label for="title">Motvo</label>
                                                 <input class="form-control" type="text" name="Motivo" />
                                             </div>
                                            <div class="form-group">
                                                 <label for="title">Fecha</label>
                                                 <input name="Fecha" type="text" class="form-control datepicker"/>
                                             </div>
                                             <div class="modal-footer">
                                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                 <button type="submit" class="btn btn-success" name="guardarHonorario" >Guardar Cambios</button>
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
