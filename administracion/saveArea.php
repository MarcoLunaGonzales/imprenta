<?php
require("conexion.inc");
include("funciones.php");


$cod_estado_registro=1;

$sql=" select max(cod_area) from areas ";
$cod_area=obtenerCodigo($sql);
$cod_estado_registro=1;



$sql="insert into areas set ";
$sql.=" cod_area='".$cod_area."',"; 
$sql.=" nombre_area='".$_POST['nombre_area']."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."',";
$sql.=" obs_area='".$_POST['obs_area']."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listAreas.php";
</script>