<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Empleado */

$this->title = $model->PrimerNomEmpleado . ' '. $model->PrimerApellEmpleado;
$this->params['breadcrumbs'][] = ['label' => 'Constancia Dependientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empleado-view">


    <h4><?= Html::encode($this->title) ?></h4>

    <p>
      <center>
        <?php $id = str_replace('id=',"", $_SERVER["QUERY_STRING"] ); ?>
        <button class="btn btn-success btn-raised btn-exp" value='<?php echo $id; ?>'>
                 GENERAR CONSTANCIA
        </button>
      </center>
    </p>
</div>


<form id="frm" action="../constanciadependiente/reporte.php" method="post" class="hidden">
  <input type="text" id="IdEmpleado" name="IdEmpleado" />
</form>

<script type="text/javascript">
    $(document).ready(function(){

        $(".btn-exp").click(function(){
            var id = $(this).attr("value");
            $("#IdEmpleado").val(id);
            $("#frm").submit();
            //alert(id);
        });
    });

</script>
