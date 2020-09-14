<?php
$cod_almacen_global=$_GET['cod_almacen_global'];
setcookie("cod_almacen_global", $cod_almacen_global, time()+28800,"/","");	
header("Location:cuerpoIntranet.php?cod_modulo=".$_GET['cod_modulo']);

?>
