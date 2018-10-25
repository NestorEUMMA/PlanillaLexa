<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

$urlperupdate = '../accionpersonal/update';
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
/* @var $model app\models\Accionpersonal */

$this->title = $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Accion Personal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accionpersonal-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>

        <?php
                if($urlperupdate == $resupdate['URL'] and $activoupdate == 1){
                  ?>
                      <?= Html::a('Actualizar', ['update', 'id' => $model->IdAccionPersonal], ['class' => 'btn btn-z']) ?>
                    <?php
                }
                else{
                  $update = '';
                }
          ?>
          <?= Html::a('Imprimir', ['report', 'id' => $model->IdAccionPersonal], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdAccionPersonal',
            'idEmpleado.fullname',
            'Motivo',
                        [
            'attribute' => 'Descuento',
            'value' => function ($model) {
            return '$' . ' ' . $model->Descuento;
            }
            ],
            'FechaAccion',
            'PeriodoAccion',
            'MesAccion',
        ],
    ]) ?>

</div>
