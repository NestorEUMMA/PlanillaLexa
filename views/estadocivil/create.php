<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estadocivil */

$this->title = 'Ingresar Estado Civil';
$this->params['breadcrumbs'][] = ['label' => 'Estado Civil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



