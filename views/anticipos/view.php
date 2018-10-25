<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

$urlperupdate = '../anticipos/update';
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
/* @var $model app\models\Anticipos */

$this->title = $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Anticipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anticipos-view">

    <h4><?= Html::encode($this->title) ?></h4>


    <p>
      <?php
              if($urlperupdate == $resupdate['URL'] and $activoupdate == 1){
                ?>
                  <?= Html::a('Actualizar', ['update', 'id' => $model->IdAnticipo], ['class' => 'btn btn-warning']) ?>
                  <?php
              }
              else{
                $update = '';
              }
        ?>

        <?= Html::a('Imprimir', ['report', 'id' => $model->IdAnticipo], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdAnticipo',
             'idEmpleado.fullname',
            'FechaAnticipos',
                           [
       'attribute' => 'MontoAnticipo',
       'value' => function ($model) {
           return '$' . ' ' . $model->MontoAnticipo;
       }
    ] ,
            'MesPeriodoAnticipo',
            'AnoPeriodoAnticipo',
        ],
    ]) ?>

</div>
<form id="frm" action="../anticipos/reporte.php" method="post" class="hidden">
  <input type="text" id="IdAnticipo" name="IdAnticipo" />
</form>
