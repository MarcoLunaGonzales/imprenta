<?php
require("conexion.inc");
include("funciones.php");

$nombre_almacen=$_POST['nombre_almacen'];
$cod_sucursal=$_POST['cod_sucursal'];
$cod_estado_registro=1;

$sql=" select max(cod_almacen) from almacenes ";
$cod_almacen=obtenerCodigo($sql);

$sql="insert into almacenes set ";
$sql.=" cod_almacen='".$cod_almacen."',"; 
$sql.=" nombre_almacen='".$nombre_almacen."',"; 
$sql.=" cod_sucursal='".$cod_sucursal."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorAlmacenes.php";
</script>