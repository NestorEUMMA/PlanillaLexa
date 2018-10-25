<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Departamentoempresa */

$this->title = 'Ingresar Departamento Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Departamento Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



