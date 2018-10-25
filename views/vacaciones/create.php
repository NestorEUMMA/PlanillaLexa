<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vacaciones */

$this->title = 'Ingresar Vacaciones';
$this->params['breadcrumbs'][] = ['label' => 'Vacaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



