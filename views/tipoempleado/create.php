<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tipoempleado */

$this->title = 'Ingresar Tipo Empleado';
$this->params['breadcrumbs'][] = ['label' => 'Tipoempleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



