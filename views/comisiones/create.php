<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Comisiones */

$this->title = 'Ingresar Comisiones';
$this->params['breadcrumbs'][] = ['label' => 'Comisiones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



