<?php
require("conexion.inc");
include("funciones.php");

$cod_grado=$_POST['cod_grado'];
$desc_grado=$_POST['desc_grado'];
$abrev_grado=$_POST['abrev_grado'];

$cod_estado_registro=$_POST['cod_estado_registro'];



$sql="update grado_academico set ";
$sql.=" desc_grado='".$desc_grado."',"; 
$sql.=" abrev_grado='".$abrev_grado."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_grado=".$cod_grado.""; 

mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorGradoAcademico.php";
</script>