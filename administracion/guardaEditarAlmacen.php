<?php
require("conexion.inc");
include("funciones.php");

$cod_almacen=$_POST['cod_almacen'];
$nombre_almacen=$_POST['nombre_almacen'];
$cod_sucursal=$_POST['cod_sucursal'];
$cod_estado_registro=$_POST['cod_estado_registro'];


$sql="update almacenes set ";
$sql.=" nombre_almacen='".$nombre_almacen."',"; 
$sql.=" cod_sucursal='".$cod_sucursal."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_almacen='".$cod_almacen."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorAlmacenes.php";
</script>