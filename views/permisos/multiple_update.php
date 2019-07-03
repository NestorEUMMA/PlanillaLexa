<?php

require_once '../../include/database_connection.php';





if(isset($_POST['hidden_id']))
{
 $gender = $_POST['gender'];
 $id = $_POST['hidden_id'];
 for($count = 0; $count < count($id); $count++)
 {
  $data = array(
   ':gender'  => $gender[$count],
   ':id'   => $id[$count]
  );
  $query = "
  UPDATE menuusuario 
  SET MenuUsuarioActivo = :gender
  WHERE IdMenuUsuario = :id
  ";
  $statement = $connect->prepare($query);
  $statement->execute($data);
 }
}

?>

?>

