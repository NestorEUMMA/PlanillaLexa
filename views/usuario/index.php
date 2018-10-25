<?php

use yii\helpers\Html;
use yii\grid\GridView;

// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

 $urlperupdate = '../usuario/update';
 $urlperview = '../usuario/view';
 $urlpercreate = '../usuario/create';
 $urlperdelete = '../usuario/delete';
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

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;

include '../include/dbconnect.php';
  $querypuesto = "select IdPuesto, Descripcion from puesto";
      $resultadoquerypuesto = $mysqli->query($querypuesto);
?>

<div align="right">
  <?php
          if($urlpercreate == $urlcreate and $activocreate == 1){
            ?>
            <button class="btn btn-success btn-raised " data-toggle="modal" data-target="#myModal">
                                         Nuevo Usuario
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

                                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                            <p>

                            </p>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                    'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    //'IdUsuario',
                                    'InicioSesion',
                                    'Nombres',
                                    'Apellidos',
                                    'Correo',
                                    // 'Clave',
                                    'idPuesto.Descripcion',
                                    'FechaIngreso',
                                    [
                                    'format' => 'boolean',
                                    'attribute' => 'Activo',
                                    'filter' => [0=>'No',1=>'Si'],
                                    ],
                                    // 'LexaAdmin',

                                  ['class' => 'yii\grid\ActionColumn', 'options' => ['style' => 'width:100px;'], 'template' => " $view $update $delete "],
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
                                                      <form action="../../views/usuario/usuarioguardar.php" role="form" method="POST">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Nuevo Usuario</h4>

                                                        </div>
                                                        <div class="modal-body">
                                                         <div class="form-group">
                                                              <label for="title">Inicio de Sesion</label>
                                                              <input class="form-control" type="text" name="InicioSesion" id="username"/>
                                                               <center><div id="Info"></div></center>
                                                          </div>
                                                           <div class="form-group">
                                                              <label for="title">Nombres</label>
                                                              <input class="form-control" type="text" name="Nombre" id="" />
                                                          </div>
                                                           <div class="form-group">
                                                              <label for="title">Apellidos</label>
                                                              <input class="form-control" type="text" name="Apellido" id="" />
                                                          </div>
                                                           <div class="form-group">
                                                              <label for="title">Correo</label>
                                                              <input class="form-control" type="email" name="Correo" id="" />
                                                          </div>
                                                           <div class="form-group">
                                                              <label for="title">Clave</label>
                                                              <input class="form-control" type="text" name="clave" id="" />
                                                          </div>
                                                          <div class="form-group">
                                                              <label for="title">Seleccione un Puesto:</label>
                                                            <select name="Puesto" class="form-control">
                                                              <option value="">--- Seleccione un Puesto ---</option>
                                                              <?php
                                                                  while($row = $resultadoquerypuesto->fetch_assoc()){
                                                                      echo "<option value='".$row['IdPuesto']."'>".$row['Descripcion']."</option>";
                                                                  }
                                                              ?>
                                                          </select>
                                                          </div>
                                                          <div class="form-group">
                                                              <label for="title">Activo</label>
                                                              <select name="activo" class="form-control">
                                                                <option value="0">INACTIVO</option>
                                                                    <option value="1">ACTIVO</option>
                                                              </select>
                                                          </div>
                                                          <div class="modal-footer">
                                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                              <button type="submit" class="btn btn-success" name="guardarHonorario" >Guardar Usuario</button>
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

<script type="text/javascript">

    $(document).ready(function() {
    $('#username').blur(function(){

        $('#Info').html('<img src="loader.gif" alt="" />').fadeOut(1000);

        var username = $(this).val();
        var dataString = 'username='+username;

        $.ajax({
                type: "POST",
                url: "../../views/usuario/check.php",
                 data: dataString,
                success: function

                (data) {
            $('#Info').fadeIn(1000).html(data);
            //alert(data);
                }
            });
        });
    });

</script>
