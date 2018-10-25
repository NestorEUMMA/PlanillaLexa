<?php
$array = split("\n", file_get_contents('C:\PlanillaLEXA\conexion.txt'));
$localhost = $array[0];
$db = trim($array[1]);
$usuario = trim($array[2]);
$clave = trim($array[3]);

if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
if (!defined('DB_USERNAME')) define('DB_USERNAME', $usuario);
if (!defined('DB_DATABASE')) define('DB_DATABASE', $db);
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', $clave);


$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($mysqli === false) {
die ("ERROR: No se estableció la conexión. " . mysqli_connect_error());
}

$mysqli->set_charset("utf8");


?>
