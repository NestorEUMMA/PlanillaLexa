<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Menuusuario */

$this->title = 'Ingresar Menuusuario';
$this->params['breadcrumbs'][] = ['label' => 'Menuusuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



