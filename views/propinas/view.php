<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }

$urlperupdate = '../propinas/update';
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
/* @var $model app\models\Propinas */

$this->title = $model->IdPropina;
$this->params['breadcrumbs'][] = ['label' => 'Propinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="propinas-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?php
                if($urlperupdate == $urlupdate and $activoupdate == 1){
                  ?>
                      <?= Html::a('Actualizar', ['update', 'id' => $model->IdPropina], ['class' => 'btn btn-z']) ?>
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
            // 'IdPropina',
            'idEmpleado.fullname',
            'Fecha',
            'PropinaPeriodo',
            'PropinaMes',
              [
                'attribute' => 'MontoPropina',
                'value' => function ($model) {
                    return '$' . ' ' . $model->MontoPropina;
                }
             ],
        ],
    ]) ?>

</div>
