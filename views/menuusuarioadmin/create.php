<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Menuusuario */

$this->title = 'Ingresar Menu Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Menu Usuario', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
