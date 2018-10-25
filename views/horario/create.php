<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Horario */

$this->title = 'Ingresar Horario';
$this->params['breadcrumbs'][] = ['label' => 'Horarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



