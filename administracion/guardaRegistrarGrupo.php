<?php
require("conexion.inc");
include("funciones.php");

$nombre_grupo=$_POST['nombre_grupo'];
$abrev_grupo=$_POST['abrev_grupo'];
$cod_estado_registro=1;

$sql=" select max(cod_grupo) from grupos ";
$cod_grupo=obtenerCodigo($sql);

$sql="insert into grupos set ";
$sql.=" cod_grupo='".$cod_grupo."',"; 
$sql.=" nombre_grupo='".$nombre_grupo."',"; 
$sql.=" abrev_grupo='".$abrev_grupo."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorGrupos.php";
</script>