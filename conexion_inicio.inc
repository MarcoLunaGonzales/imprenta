<?php
date_default_timezone_set('America/Caracas');
if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
	
}

$con=mysql_connect("localhost","root","");
$bd=mysql_select_db("impr_jenisse");

if(!isset($_GET['cod_modulo'])){
   include("librerias_ajax_iframe.php"); 
}
?>
