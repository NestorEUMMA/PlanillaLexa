<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
require("tools/NumeroALetras.php");
if(!isset($_SESSION))
    {
        session_start();
    }

$urlperupdate = '../horasextras/update';
$usuario = $_SESSION['user'];


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

$id = $model->IdHorasExtras;

$mes = strftime("%B");
   if($mes == 'January'){
       $mes = 'Enero';
   }
   elseif($mes == 'February'){
       $mes = 'Febrero';
   }
   elseif($mes == 'March'){
       $mes = 'Marzo';
   }
   elseif($mes == 'April'){
       $mes = 'Abril';
   }
   elseif($mes == 'May'){
       $mes = 'Mayo';
   }
   elseif($mes == 'June'){
       $mes = 'Junio';
   }
   elseif($mes == 'July'){
       $mes = 'Julio';
   }
   elseif($mes == 'August'){
       $mes = 'Agosto';
   }
   elseif($mes == 'September'){
       $mes = 'Septiembre';
   }
   elseif($mes == 'October'){
       $mes = 'Octubre';
   }
   elseif($mes == 'November'){
       $mes = 'Noviembre';
   }
   else{
       $mes = 'Diciembre';
   }

$anio = date("Y");

$dias = strftime("%d");
$dia = strftime("%A");
if($dia == 'Monday'){
   $dia = 'Lunes';
}
elseif($dia == 'Tuesday'){
   $dia = 'Martes';
}
elseif($dia == 'Wednesday'){
   $dia = 'Miercoles';
}
elseif($dia == 'Thursday'){
   $dia = 'Jueves';
}
elseif($dia == 'Friday'){
   $dia = 'Viernes';
}
elseif($dia == 'Saturday'){
   $dia = 'Sabado';
}
else{
   $dia = 'otro dia';
}

$queryhorasextras = "SELECT  h.FechaHorasExtras, h.AnoPeriodoHorasExt, h.TipoHoraExtra,
  CONCAT(e.PrimerNomEmpleado,' ', e.SegunNomEmpleado,' ',e.PrimerApellEmpleado,' ',e.SegunApellEmpleado) as 'NombreCompleto',
  e.Nit, h.MontoHorasExtras, h.MontoISRHorasExtras, h.MontoHorasExtrasTot, h.HorasAFP, h.HorasISSS FROM horasextras h
  INNER JOIN empleado e on h.IdEmpleado = e.IdEmpleado
  WHERE h.IdHorasExtras = '$id'";
$resultadoqueryhorasextras = $mysqli->query($queryhorasextras);
while ($test = $resultadoqueryhorasextras->fetch_assoc())
          {
              $fecha = $test['FechaHorasExtras'];
              $periodo = $test['AnoPeriodoHorasExt'];
              $nombre = $test['NombreCompleto'];
              $nit = $test['Nit'];
              $concepto = $test['TipoHoraExtra'];
              $monto = $test['MontoHorasExtras'];
              $isr = $test['MontoISRHorasExtras'];
              $pagar = $test['MontoHorasExtrasTot'];
              $isss = $test['HorasISSS'];
              $afp = $test['HorasAFP'];
          }

   $n = $pagar;
   $aux = (string) $n;
   $decimal = substr( $aux, strpos( $aux, "." ) );
   $centavos = str_replace('.',"", $decimal );



$queryempresa = "select e.NombreEmpresa, e.Direccion, e.NitEmpresa, d.NombreDepartamento
               from empresa e
               inner join departamentos d on e.IdDepartamentos = d.IdDepartamentos
               where IdEmpresa = 1";
$resultadoqueryempresa = $mysqli->query($queryempresa);

while ($test = $resultadoqueryempresa->fetch_assoc())
          {
              $empresa = $test['NombreEmpresa'];
              $direccion = $test['Direccion'];
              $nitempresa = $test['NitEmpresa'];
              $departamento = $test['NombreDepartamento'];

          }

/* @var $this yii\web\View */
/* @var $model app\models\Horasextras */

$this->title = $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Horasextras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
</br>
<div class="row">
  <div class="col-md-12">
  <div class="card">
          <div class="card-header card-header-icon" data-background-color="orange">
              <i class="material-icons">mail_outline</i>
          </div>
          <div class="card-content">
                  <center>
                    <div class="row">
                        <div class="col-md-12">
                          <h4 class="page">
                            <center><strong><?php echo $empresa; ?></strong></br>
                            <strong>CONSTANCIA DE RETENCION</strong></br>
                            <strong><small><?php echo $direccion; ?></small></strong>
                            </br><strong><small><?php echo $nitempresa; ?></small></strong>
                            </center>
                          </h4>
                        </div>

                    </div>
                  </center>
                  <center>
                  <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                      <p> Recibi de la sociedad <?php echo $empresa; ?>, la cantidad de: <u> <?php echo $apagar = NumeroALetras::convertir($pagar); ?> <?php echo $centavos; ?>/100 </u>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                      <p> En concepto de: <u><?php echo $concepto; ?> </u>
                      </br>Y dando cumplimiento a la Ley de Impuesto sobre la Renta, se efectúa la siguiente retención de Renta:
                    </div>
                  </div>
                  <!-- <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                     <p> Por: $ <?php echo $monto; ?>
                      </br>10% ISR: <u>$ <?php echo $isr; ?> </u>
                      </br>Total a Pagar: $ <?php echo $pagar; ?>
                    </div>
                  </div> -->
                  <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                     <p> Por: $ <?php echo $monto; ?>
                     </br>ISSS: <u>$ <?php echo $isss; ?> </u>
                   </br>AFP: <u>$ <?php echo $afp; ?> </u>
                      </br>Total a Pagar: $ <?php echo $pagar; ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                    <p><?php echo $departamento; ?>, <?php echo $dia; ?>, <?php echo $dias; ?> de <?php echo $mes; ?> de <?php echo $anio; ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                    <p><strong> Recibi conforme: </strong>
                    </br>
                    </br>
                    </br>Firma:__________________________________________
                    </br>Nombre: <?php echo $nombre ?>
                  </br>NIT: <?php echo $nit ?>
                    </div>
                  </div>
                  </center>
          </div>
          <div class="col-xs-12">
            <center>
              <a href="../horasextras/index" class="btn btn-warning"></i> REGRESAR</a>
            <button class="btn btn-success btn-raised btn-exp" onclick="javascript:window.imprimirDIV('ID_DIV');">Imprimir </button>
          </center>
        </div>
          <div id="ID_DIV" class="hidden">
            </br></br>
                    <center>
                      <div class="row">
                          <div class="col-md-12">
                            <h4 class="page">
                              <center><strong><?php echo $empresa; ?></strong></br>
                              <strong>CONSTANCIA DE RETENCION</strong></br>
                              <strong><small><?php echo $direccion; ?></small></strong>
                              </br><strong><small><?php echo $nitempresa; ?></small></strong>
                              </center>
                            </h4>
                          </div>

                      </div>
                    </center>
                    <center>
                    <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                        <p> Recibi de la sociedad <?php echo $empresa; ?>, la cantidad de: <u> <?php echo $apagar = NumeroALetras::convertir($pagar); ?> <?php echo $centavos; ?>/100 </u>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                        <p> En concepto de: <u><?php echo $concepto; ?> </u>
                        </br>Y dando cumplimiento a la Ley de Impuesto sobre la Renta, se efectúa la siguiente retención de Renta:
                      </div>
                    </div>
                    <!-- <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                       <p> Por: $ <?php echo $monto; ?>
                        </br>10% ISR: <u>$ <?php echo $isr; ?> </u>
                        </br>Total a Pagar: $ <?php echo $pagar; ?>
                      </div>
                    </div> -->
                    <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                       <p> Por: $ <?php echo $monto; ?>
                       </br>ISSS: <u>$ <?php echo $isss; ?> </u>
                     </br>AFP: <u>$ <?php echo $afp; ?> </u>
                        </br>Total a Pagar: $ <?php echo $pagar; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                      <p><?php echo $departamento; ?>, <?php echo $dia; ?>, <?php echo $dias; ?> de <?php echo $mes; ?> de <?php echo $anio; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                      <p><strong> Recibi conforme: </strong>
                      </br>
                      </br>
                      </br>Firma:__________________________________________
                      </br>Nombre: <?php echo $nombre ?>
                    </br>NIT: <?php echo $nit ?>
                      </div>
                    </div>
                    </center>
                      </br></br></br>
                      ___________________________________________________________________________________________________________________________________________
                      </br></br></br>
                      <center>
                        <div class="row">
                            <div class="col-md-12">
                              <h4 class="page">
                                <center><strong><?php echo $empresa; ?></strong></br>
                                <strong>CONSTANCIA DE RETENCION</strong></br>
                                <strong><small><?php echo $direccion; ?></small></strong>
                                </br><strong><small><?php echo $nitempresa; ?></small></strong>
                                </center>
                              </h4>
                            </div>

                        </div>
                      </center>
                      <center>
                      <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                          <p> Recibi de la sociedad <?php echo $empresa; ?>, la cantidad de: <u> <?php echo $apagar = NumeroALetras::convertir($pagar); ?> <?php echo $centavos; ?>/100 </u>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                          <p> En concepto de: <u><?php echo $concepto; ?> </u>
                          </br>Y dando cumplimiento a la Ley de Impuesto sobre la Renta, se efectúa la siguiente retención de Renta:
                        </div>
                      </div>
                      <!-- <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                         <p> Por: $ <?php echo $monto; ?>
                          </br>10% ISR: <u>$ <?php echo $isr; ?> </u>
                          </br>Total a Pagar: $ <?php echo $pagar; ?>
                        </div>
                      </div> -->
                      <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                         <p> Por: $ <?php echo $monto; ?>
                         </br>ISSS: <u>$ <?php echo $isss; ?> </u>
                       </br>AFP: <u>$ <?php echo $afp; ?> </u>
                          </br>Total a Pagar: $ <?php echo $pagar; ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                        <p><?php echo $departamento; ?>, <?php echo $dia; ?>, <?php echo $dias; ?> de <?php echo $mes; ?> de <?php echo $anio; ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                        <p><strong> Recibi conforme: </strong>
                        </br>
                        </br>
                        </br>Firma:__________________________________________
                        </br>Nombre: <?php echo $nombre ?>
                      </br>NIT: <?php echo $nit ?>
                        </div>
                      </div>
                      </center>

          </div>

          <script>
            function imprimirDIV(contenido) {
                 var getpanel = document.getElementById(contenido);
                 var MainWindow = window.open(' ', 'popUp');
                 MainWindow.document.write('<html><head><title>IMPRESION</title>');
                 MainWindow.document.write("<link rel=\"stylesheet\" href=\"../template/css/style0.css\" type=\"text/css\"/>");
                 MainWindow.document.write('</head><body onload="window.print();window.close()">');
                 MainWindow.document.write(getpanel.innerHTML);
                 MainWindow.document.write('</body></html>');
                 MainWindow.document.close();
                 setTimeout(function () {
                     MainWindow.print();
                 }, 500)
                  return false;
                }
          </script>
      </div>
    </div>
</div>
