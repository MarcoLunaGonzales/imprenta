<?php
require("conexion.inc");
include("funciones.php");

$nombre_sucursal=$_POST['nombre_sucursal'];
$cod_ciudad=$_POST['cod_ciudad'];
$direccion_sucursal=$_POST['direccion_sucursal'];
$telf_sucursal=$_POST['telf_sucursal'];
$cod_estado_registro=1;

$sql=" select max(cod_sucursal) from sucursales ";
$cod_sucursal=obtenerCodigo($sql);

$sql="insert into sucursales set ";
$sql.=" cod_sucursal='".$cod_sucursal."',"; 
$sql.=" nombre_sucursal='".$nombre_sucursal."',"; 
$sql.=" cod_ciudad='".$cod_ciudad."',";
$sql.=" direccion_sucursal='".$direccion_sucursal."',";
$sql.=" telf_sucursal='".$telf_sucursal."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorSucursales.php";
</script>