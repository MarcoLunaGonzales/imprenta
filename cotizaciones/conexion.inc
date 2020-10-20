<?php
if($_COOKIE['usuario_global']==""){

	header("location:../index.html"); 
}else{
/*date_default_timezone_set('America/Caracas');
if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
}

<<<<<<< HEAD
$con=mysql_connect("localhost","root","4868422Marco");
$bd=mysql_select_db("imprenta");

=======
  $con=mysql_connect("localhost","root","");
$bd=mysql_select_db("impr_jenisse");
*/
require_once ("../conexion_inicio.inc");
>>>>>>> 7c1129ae3c98add5e9c6c169df35019d1fea90a6
}

?>