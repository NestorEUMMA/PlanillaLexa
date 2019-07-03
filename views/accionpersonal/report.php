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
   
   
   
   /* @var $this yii\web\View */
   /* @var $model app\models\Anticipos */
   
   $this->title = 'Vista Previa de Accion de Persona: ' . $model->idEmpleado->fullname;
   $this->params['breadcrumbs'][] = ['label' => 'Anticipos', 'url' => ['index']];
   $this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdAccionPersonal]];
   $this->params['breadcrumbs'][] = 'Vista Previa';
   
   $id = $model->IdAccionPersonal;
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
   
   $queryanticipo = "SELECT a.FechaAccion, a.PeriodoAccion, a.MesAccion, CONCAT(e.PrimerNomEmpleado,' ', e.SegunNomEmpleado,' ',e.PrimerApellEmpleado,' ',e.SegunApellEmpleado) as 'NombreCompleto',
   a.Descuento, e.Nit, a.Motivo
   from accionpersonal a
   INNER JOIN empleado e on a.IdEmpleado = e.IdEmpleado
   WHERE a.IdAccionPersonal =  '$id'";
   $resultadoqueryanticipo = $mysqli->query($queryanticipo);
   while ($test = $resultadoqueryanticipo->fetch_assoc())
             {
                 $fecha = $test['FechaAccion'];
                 $periodo = $test['PeriodoAccion'];
                 $nombre = $test['NombreCompleto'];
                 $nit = $test['Nit'];
                 $pagar = $test['Descuento'];
                 $motivo = $test['Motivo'];
   
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
   
   ?>
</br>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header card-header-icon" data-background-color="orange">
            <i class="material-icons">mail_outline</i>
         </div>
         <div class="card-content">
            <h4 class="card-title">Vista Previa de Acciones de Personal</h4>
            <center>
               <div class="row">
                  <div class="col-md-12">
                     <h4 class="page">
                        <center><strong><?php echo $empresa; ?></strong></br>
                           <strong>ACCION DE PERSONAL</strong></br>
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
                     <p> Descuento de: <u> <?php echo $apagar = NumeroALetras::convertir($pagar); ?> <?php echo $centavos; ?>/100 </u>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <p> Justificacion: <u><?php echo $motivo; ?></u>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     Descuento: $ <?php echo $pagar; ?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <p><?php echo $departamento; ?>, <?php echo $dia; ?>, <?php echo $dias; ?> de <?php echo $mes; ?> de <?php echo $anio; ?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
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
               <a href="../accionpersonal/index" class="btn btn-warning"></i> REGRESAR</a>
               <button class="btn btn-success btn-raised btn-exp" onclick="javascript:window.imprimirDIV('ID_DIV');">Imprimir </button>
            </center>
         </div>
         <div id="ID_DIV" class="hidden">
            <center>
               <div class="row">
                  <div class="col-md-12">
                     <h4 class="page">
                        <center><strong><?php echo $empresa; ?></strong></br>
                           <strong>ACCION DE PERSONAL</strong></br>
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
                     <p> Descuento de: <u> <?php echo $apagar = NumeroALetras::convertir($pagar); ?> <?php echo $centavos; ?>/100 </u>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <p> Justificacion: <u><?php echo $motivo; ?></u>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     Descuento: $ <?php echo $pagar; ?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <p><?php echo $departamento; ?>, <?php echo $dia; ?>, <?php echo $dias; ?> de <?php echo $mes; ?> de <?php echo $anio; ?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     </br>
                     </br>Firma:__________________________________________
                     </br>Nombre: <?php echo $nombre ?>
                     </br>NIT: <?php echo $nit ?>
                  </div>
               </div>
            </center>
            </br>
            </br>
            </br>
            </br>
            </br>
            ___________________________________________________________________________________________________________________________________________
            </br>
            </br>
            <center>
               <div class="row">
                  <div class="col-md-12">
                     <h4 class="page">
                        <center><strong><?php echo $empresa; ?></strong></br>
                           <strong>ACCION DE PERSONAL</strong></br>
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
                     <p> Descuento de: <u> <?php echo $apagar = NumeroALetras::convertir($pagar); ?> <?php echo $centavos; ?>/100 </u>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <p> Justificacion: <u><?php echo $motivo; ?></u>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     Descuento: $ <?php echo $pagar; ?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <p><?php echo $departamento; ?>, <?php echo $dia; ?>, <?php echo $dias; ?> de <?php echo $mes; ?> de <?php echo $anio; ?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     </br>
                     </br>Firma:__________________________________________
                     </br>Nombre: <?php echo $nombre ?>
                     </br>NIT: <?php echo $nit ?>
                  </div>
               </div>
            </center>
         </div>
      </div>
   </div>
</div>
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