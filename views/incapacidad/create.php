<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Incapacidad */

$this->title = 'Ingresar Incapacidad';
$this->params['breadcrumbs'][] = ['label' => 'Incapacidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



