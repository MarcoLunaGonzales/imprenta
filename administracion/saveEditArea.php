<?php
require("conexion.inc");
include("funciones.php");

$sql="update areas set ";
$sql.=" nombre_area='".$_POST['nombre_area']."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."',";
$sql.=" obs_area='".$_POST['obs_area']."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_area='".$_POST['cod_area']."'"; 
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listAreas.php";
</script>
