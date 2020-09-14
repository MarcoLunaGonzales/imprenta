<?php
require("conexion.inc");
include("funciones.php");

$cod_sucursal=$_POST['cod_sucursal'];
$nombre_sucursal=$_POST['nombre_sucursal'];
$cod_ciudad=$_POST['cod_ciudad'];
$direccion_sucursal=$_POST['direccion_sucursal'];
$telf_sucursal=$_POST['telf_sucursal'];
$cod_estado_registro=$_POST['cod_estado_registro'];


$sql="update sucursales set ";
$sql.=" nombre_sucursal='".$nombre_sucursal."',"; 
$sql.=" cod_ciudad='".$cod_ciudad."',";
$sql.=" direccion_sucursal='".$direccion_sucursal."',";
$sql.=" telf_sucursal='".$telf_sucursal."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_sucursal='".$cod_sucursal."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorSucursales.php";
</script>