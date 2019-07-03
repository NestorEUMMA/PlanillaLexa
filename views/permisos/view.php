<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
include '../include/dbconnect.php';
$this->title = 'Permisos de Usuario para: '.$model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$InicioSesion = $model->InicioSesion;
$IdUsuario = $model->IdUsuario;
?>
<div class="usuario-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>

    </p>

    <form method="post" id="update_form">
          <div align="right">
              <input type="submit" name="multiple_update" id="multiple_update" class="btn btn-success" value="Actualizacion" />
          </div>
          <br />
          <div class="table-responsive">
              <table class="table table-bordered table-striped">
                  <thead>
                      <th width="5%"></th>
                      <th width="20%">Menu</th>
                      <th width="30%">Submenu</th>
                      <th width="15%">Activo</th>
                  </thead>
                  <tbody></tbody>
              </table>
          </div>
      </form>

</div>


<script>

$(document).ready(function(){

    function fetch_data()
    {
      var id = <?php echo $IdUsuario ?> ;
           var myData = {"id": id};
        $.ajax({
            url:"../../views/permisos/select.php",
            method:"POST",
            data: myData,
            dataType:"json",
            success:function(data)
            {
                var html = '';
                for(var count = 0; count < data.length; count++)
                {
                    html += '<tr>';
                    html += '<td><input type="checkbox" id="'+data[count].id+'" data-name="'+data[count].name+'" data-address="'+data[count].address+'" data-gender="'+data[count].gender+'" data-designation="'+data[count].designation+'" data-age="'+data[count].age+'" class="check_box"  /></td>';
                    html += '<td>'+data[count].name+'</td>';
                    html += '<td>'+data[count].address+'</td>';
                    html += '<td>'+data[count].gender+'</td>';
                }
                $('tbody').html(html);
            }
        });
    }

  fetch_data();

    $(document).on('click', '.check_box', function(){
        var html = '';
        if(this.checked)
        {
            html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-name="'+$(this).data('name')+'" data-address="'+$(this).data('address')+'" data-gender="'+$(this).data('gender')+'" class="check_box" checked /></td>';
            html += '<td><input type="text" name="name[]" class="form-control" value="'+$(this).data("name")+'" /></td>';
            html += '<td><input type="text" name="address[]" class="form-control" value="'+$(this).data("address")+'" /></td>';
            html += '<td><select name="gender[]" id="gender_'+$(this).attr('id')+'" class="form-control"><option value="1">ACTIVO</option><option value="0">INACTIVO</option></select></td><input type="hidden" name="hidden_id[]" value="'+$(this).attr('id')+'" />';

        }
        else
        {
            html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-name="'+$(this).data('name')+'" data-address="'+$(this).data('address')+'" data-gender="'+$(this).data('gender')+'" class="check_box" /></td>';
            html += '<td>'+$(this).data('name')+'</td>';
            html += '<td>'+$(this).data('address')+'</td>';
            html += '<td>'+$(this).data('gender')+'</td>';

        }
        $(this).closest('tr').html(html);
        $('#gender_'+$(this).attr('id')+'').val($(this).data('gender'));
    });

    $('#update_form').on('submit', function(event){
        event.preventDefault();
        if($('.check_box:checked').length > 0)
        {
            $.ajax({
                url:"../../views/permisos/multiple_update.php",
                method:"POST",
                data:$(this).serialize(),
                success:function()
                {
                    alert('Permiso Actualizado');
                    fetch_data();
                }
            })
        }
    });

});
</script>
