<?php
date_default_timezone_set('America/Caracas');
if($_COOKIE['usuario_global']==""){

	header("location:../index.html"); 
}else{
/*if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
}

  $con=mysql_connect("localhost","root","");
$bd=mysql_select_db("impr_jenisse");

	date_default_timezone_set('America/Caracas');
	*/
	require_once ("../conexion_inicio.inc");
}

?>