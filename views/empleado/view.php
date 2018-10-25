<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

$urlperupdate = '../empleado/update';
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


/* @var $this yii\web\View */
/* @var $model app\models\Empleado */

$this->title = $model->PrimerNomEmpleado . ' '. $model->PrimerApellEmpleado;
$this->params['breadcrumbs'][] = ['label' => 'Empleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empleado-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
      <?php
              if($urlperupdate == $urlupdate and $activoupdate == 1){
                ?>
                  <?= Html::a('Actualizar', ['update', 'id' => $model->IdEmpleado], ['class' => 'btn btn-z']) ?>
                  <?php
              }
              else{
                $update = '';
              }
        ?>

        <?= Html::a('Imprimir Contrato', ['report', 'id' => $model->IdEmpleado], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdEmpleado',
            'Nup',
            'idTipoDocumento.DescripcionTipoDocumento',
            'NumTipoDocumento',
            'DuiExpedido',
            'DuiEl',
            'DuiDe',
            'idInstitucionPre.DescripcionInstitucion',
            'Genero',
            'PrimerNomEmpleado',
            'SegunNomEmpleado',
            'PrimerApellEmpleado',
            'SegunApellEmpleado',
            'ApellidoCasada',
            'ConocidoPor',
            'idTipoEmpleado.DescipcionTipoEmpleado',
            'idEstadoCivil.DescripcionEstadoCivil',
            'FNacimiento',
            'NIsss',
            'MIpsfa',
            'Nit',

            'Direccion',
            'idDepartamentos.NombreDepartamento',
            'idMunicipios.DescripcionMunicipios',
            'CorreoElectronico',
            'TelefonoEmpleado',
            'CelularEmpleado',
            'Profesion',
            'OtrosDatos',

            'CBancaria',
            'idBanco.DescripcionBanco',
            // 'JefeInmediato',
            'CasoEmergencia',
            'TeleCasoEmergencia',
            'Dependiente1',
            'Dependiente2',
            'Dependiente3',
            'Beneficiario',
            'DocumentBeneficiario',
            'NDocBeneficiario',

            'DeducIsssAfp:boolean',
            'DeducIsssIpsfa:boolean',
            'NoDependiente:boolean',
            'SalarioNominal',
            'HerramientasTrabajo',
            'idPuestoEmpresa.DescripcionPuestoEmpresa',
            'EmpleadoActivo:boolean',
            'FechaContratacion',
            'FechaDespido',


            [
               'attribute'=>'EmpleadoImagen',
               'value'=> Yii::$app->homeUrl.'/'.$model->EmpleadoImagen,
               'format' => ['image',['width'=>'100','height'=>'100']],
            ],
        ],
    ]) ?>

</div>


<!-- <form id="frm" action="../../report/contrato/index" method="post" class="hidden">
  <input type="text" id="IdEmpleado" name="IdEmpleado" />
</form> -->
<form id="frm" action="../empleado/reporte.php" method="post" class="hidden">
  <input type="text" id="IdEmpleado" name="IdEmpleado" />
</form>

<script type="text/javascript">
    $(document).ready(function(){

        $(".btn-exp").click(function(){
            var id = $(this).attr("value");
            $("#IdEmpleado").val(id);
            $("#frm").submit();
            //alert(id);
        });
    });

</script>
