<?php

$array = split("\n", file_get_contents('C:\PlanillaLEXA\conexion.txt'));
$localhost = $array[0];
$db = trim($array[1]);
$usuario = trim($array[2]);
$clave = trim($array[3]);

$connect = new PDO('mysql:host=localhost;dbname='. $db.'',''.$usuario.'',''.$clave.'');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO events
 (title, start_event, end_event)
 VALUES (:title, :start_event, :end_event)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end']
  )
 );
}


?>
