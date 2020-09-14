<?php
require("conexion.inc");
include("funciones.php");

$nombre_unidad_medida=$_POST['nombre_unidad_medida'];
$abrev_unidad_medida=$_POST['abrev_unidad_medida'];
$cod_estado_registro=1;

$sql=" select max(cod_unidad_medida) from unidades_medidas ";
$cod_unidad_medida=obtenerCodigo($sql);

$sql="insert into unidades_medidas set ";
$sql.=" cod_unidad_medida='".$cod_unidad_medida."',"; 
$sql.=" nombre_unidad_medida='".$nombre_unidad_medida."',"; 
$sql.=" abrev_unidad_medida='".$abrev_unidad_medida."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorUnidadesMedida.php";
</script>