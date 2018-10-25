<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Puestoempresa */

$this->title = 'Ingresar Puesto Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Puesto Empresa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



