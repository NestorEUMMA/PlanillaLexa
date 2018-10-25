<?php


   include '../include/dbconnect.php';	


   $sql = "SELECT * FROM menudetalle
         WHERE idMenu LIKE '%".$_GET['id']."%'"; 


   $result = $mysqli->query($sql);


   $json = [];
   while($row = $result->fetch_assoc()){
        $json[$row['IdMenuDetalle']] = $row['DescripcionMenuDetalle'];
   }


   echo json_encode($json);
?>