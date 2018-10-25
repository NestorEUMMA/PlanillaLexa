<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

$urlperupdate = '../honorario/update';
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
/* @var $model app\models\Honorario */

$this->title = $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Honorarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="honorario-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <p>
      <!-- <?php
              if($urlperupdate == $urlupdate and $activoupdate == 1){
                ?>
                  <?= Html::a('Actualizar', ['update', 'id' => $model->IdHonorario], ['class' => 'btn btn-z']) ?>
                  <?php
              }
              else{
                $update = '';
              }
        ?> -->

          <?= Html::a('Imprimir', ['report', 'id' => $model->IdHonorario], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdHonorario',
            'idEmpleado.fullname',
           // 'IdParametro',
            'ConceptoHonorario',
            'FechaHonorario',
            'MesPeriodoHono',
            'AnoPeriodoHono',
            [
       'attribute' => 'MontoHonorario',
       'value' => function ($model) {
           return '$' . ' ' . $model->MontoHonorario;
       }
    ] ,
    [
'attribute' => 'MontoISRHonorarios',
'value' => function ($model) {
   return '$' . ' ' . $model->MontoISRHonorarios;
}
] ,
    [
'attribute' => 'ISSSHonorario',
'value' => function ($model) {
   return '$' . ' ' . $model->ISSSHonorario;
}
] ,
[
'attribute' => 'AFPHonorario',
'value' => function ($model) {
return '$' . ' ' . $model->AFPHonorario;
}
],
[
'attribute' => 'MontoPagar',
'value' => function ($model) {
return '$' . ' ' . $model->MontoPagar;
}
]

        ],
    ]) ?>

</div>

<form id="frm" action="../honorario/reporte.php" method="post" class="hidden">
  <input type="text" id="IdHonorario" name="IdHonorario" />
</form>

<script type="text/javascript">
    $(document).ready(function(){

        $(".btn-exp").click(function(){
            var id = $(this).attr("value");
            $("#IdHonorario").val(id);
            $("#frm").submit();
            //alert(id);
        });
    });

</script>
