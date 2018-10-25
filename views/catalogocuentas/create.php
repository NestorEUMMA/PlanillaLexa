<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catalogocuentas */

$this->title = 'Ingresar Catalogo Cuentas';
$this->params['breadcrumbs'][] = ['label' => 'Catalogo Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



