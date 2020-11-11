<?php

if($_COOKIE['usuario_global']==""){
	header("location:../index.html"); 
}else{
	date_default_timezone_set('America/Caracas');
	if(!function_exists('register_globals')){
		include('register_globals.php');
		register_globals();
	}else{
	}

$con=mysql_connect("localhost","root","4868422Marco");
$bd=mysql_select_db("imprenta");


require_once ("../conexion_inicio.inc");
}

?>