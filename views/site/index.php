<?php


/* @var $this yii\web\View */

$this->title = 'Planilla LEXA';
?>

<div class="site-index">
  <div class="content">
      <div class="container-fluid">
          <div class="header text-center">
              <h3 class="title">Calendario</h3>
          </div>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="card card-calendar">
                      <div class="card-content" class="ps-child">
                          <div id="calendar"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var calendar = $('#calendar').fullCalendar({
   editable:true,
   header:{
    left:'prev,next today',
    center:'title',
    right:'month,agendaWeek,agendaDay'
   },
   events: 'load.php',
   selectable:true,
   selectHelper:true,
   select: function(start, end, allDay)
   {
    var title = prompt("Ingrese Titulo de Evento");
    if(title)
    {
     var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
     $.ajax({
      url:"insert.php",
      type:"POST",
      data:{title:title, start:start, end:end},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Agregado Exitosamente!");
      }
     })
    }
   },
   editable:true,
   eventResize:function(event)
   {
    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
    var title = event.title;
    var id = event.id;
    $.ajax({
     url:"update.php",
     type:"POST",
     data:{title:title, start:start, end:end, id:id},
     success:function(){
      calendar.fullCalendar('refetchEvents');
      alert('Evento Actualizado');
     }
    })
   },

   eventDrop:function(event)
   {
    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
    var title = event.title;
    var id = event.id;
    $.ajax({
     url:"update.php",
     type:"POST",
     data:{title:title, start:start, end:end, id:id},
     success:function()
     {
      calendar.fullCalendar('refetchEvents');
      alert('Evento Actualizado');
     }
    });
   },

   eventClick:function(event)
   {
    if(confirm("Esta seguro que desea Eliminar el Evento?"))
    {
     var id = event.id;
     $.ajax({
      url:"delete.php",
      type:"POST",
      data:{id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Evento Eliminado");
      }
     })
    }
   },
  });
 });
 </script>
