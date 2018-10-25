<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Configuraciongeneral */

$this->title = 'Ingresar Configuraciongeneral';
$this->params['breadcrumbs'][] = ['label' => 'Configuraciongenerals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



