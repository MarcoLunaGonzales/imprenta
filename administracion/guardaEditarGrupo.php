<?php
require("conexion.inc");
include("funciones.php");

$cod_grupo=$_POST['cod_grupo'];
$nombre_grupo=$_POST['nombre_grupo'];
$abrev_grupo=$_POST['abrev_grupo'];

$cod_estado_registro=$_POST['cod_estado_registro'];


$sql="update grupos set ";
$sql.=" nombre_grupo='".$nombre_grupo."',"; 
$sql.=" abrev_grupo='".$abrev_grupo."',"; 
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_grupo='".$cod_grupo."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorGrupos.php";
</script>
