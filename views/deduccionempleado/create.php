<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Deduccionempleado */

$this->title = 'Ingresar Deduccionempleado';
$this->params['breadcrumbs'][] = ['label' => 'Deduccionempleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



