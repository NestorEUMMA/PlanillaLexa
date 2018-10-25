<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Institucionprevisional */

$this->title = 'Ingresar Institucion Previsional';
$this->params['breadcrumbs'][] = ['label' => 'Institucionprevisionals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



