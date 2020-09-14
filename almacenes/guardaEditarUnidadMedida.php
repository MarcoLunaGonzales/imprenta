<?php
require("conexion.inc");
include("funciones.php");

$cod_unidad_medida=$_POST['cod_unidad_medida'];
$nombre_unidad_medida=$_POST['nombre_unidad_medida'];
$abrev_unidad_medida=$_POST['abrev_unidad_medida'];
$cod_unidad_medida=$_POST['cod_unidad_medida'];




$sql="update unidades_medidas set ";
$sql.=" nombre_unidad_medida='".$nombre_unidad_medida."',"; 
$sql.=" abrev_unidad_medida='".$abrev_unidad_medida."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_unidad_medida='".$cod_unidad_medida."'"; 
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorUnidadesMedida.php";
</script>