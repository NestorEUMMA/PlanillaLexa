<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Codigoobservacion */

$this->title = 'Ingresar Codigo Observacion';
$this->params['breadcrumbs'][] = ['label' => 'Codigo Observacion', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
