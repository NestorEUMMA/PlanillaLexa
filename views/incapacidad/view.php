<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Incapacidad */
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

$urlperupdate = '../bonos/update';
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

$this->title = $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Incapacidad', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incapacidad-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
      <?php
              if($urlperupdate == $urlupdate and $activoupdate == 1){
                ?>
                    <?= Html::a('Actualizar', ['update', 'id' => $model->IdIncapacidad], ['class' => 'btn btn-z']) ?>
                  <?php
              }
              else{
                $update = '';
              }
            
        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdIncapacidad',
            'idEmpleado.fullname',
            'DiasIncapacidad',
            [
                'attribute' => 'SalarioDescuento',
                'value' => function ($model) {
                    return '$' . ' ' . $model->SalarioDescuento;
                }
             ] ,
            'FechaIncapacidad',
            'PeriodoIncapacidad',
            'MesIncapacidad',
        ],
    ]) ?>

</div>


<form id="frm" action="../incapacidad/reporte.php" method="post" class="hidden">
  <input type="text" id="IdIncapacidad" name="IdBonos" />
</form>

<script type="text/javascript">
    $(document).ready(function(){

        $(".btn-exp").click(function(){
            var id = $(this).attr("value");
            $("#IdIncapacidad").val(id);
            $("#frm").submit();
            //alert(id);
        });
    });

</script>
