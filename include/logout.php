<?php
session_start();

if(!isset($_SESSION['user']))
{
	header("Location: (../index)");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location: app.php");
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user']);
	header("Location: ../index");
}
?>
