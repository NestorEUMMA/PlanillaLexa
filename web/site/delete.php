<?php

$array = split("\n", file_get_contents('C:\PlanillaLEXA\conexion.txt'));
$localhost = $array[0];
$db = trim($array[1]);
$usuario = trim($array[2]);
$clave = trim($array[3]);

if(isset($_POST["id"]))
{

$connect = new PDO('mysql:host=localhost;dbname='. $db.'',''.$usuario.'',''.$clave.'');

 $query = "DELETE from events WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>
