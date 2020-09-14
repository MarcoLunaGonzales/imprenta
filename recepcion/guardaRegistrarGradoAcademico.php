<?php
require("conexion.inc");
include("funciones.php");

$desc_grado=$_POST['desc_grado'];
$abrev_grado=$_POST['abrev_grado'];

$cod_estado_registro=$_POST['cod_estado_registro'];

$cod_estado_registro=1;



$sql=" select max(cod_grado) from grado_academico ";
$cod_grado=obtenerCodigo($sql);


$sql="insert into grado_academico set ";
$sql.=" cod_grado=".$cod_grado.","; 
$sql.=" desc_grado='".$desc_grado."',"; 
$sql.=" abrev_grado='".$abrev_grado."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
//$sql.=" cod_usuario_modifica='".$obs_cargo."',";
//$sql.=" fecha_modifica='".$obs_cargo."'";

mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorGradoAcademico.php";
</script>