<?php
$array = split("\n", file_get_contents('C:\PlanillaLEXA\conexion.txt'));
$localhost = $array[0];
$db = trim($array[1]);
$usuario = trim($array[2]);
$clave = trim($array[3]);
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname='. $db.'',
    'username' => ''.$usuario.'',
    'password' => ''.$clave.'',
    'charset' => 'utf8',
];
echo $db;
