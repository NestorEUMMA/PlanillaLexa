<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Accionpersonal */

$this->title = 'Ingresar Accion Personal';
$this->params['breadcrumbs'][] = ['label' => 'Accion Personal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
