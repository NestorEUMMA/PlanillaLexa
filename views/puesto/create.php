<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Puesto */

$this->title = 'Ingresar Puesto';
$this->params['breadcrumbs'][] = ['label' => 'Puestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



