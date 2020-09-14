<?php
require("conexion.inc");
include("funciones.php");

$desc_gasto=$_POST['desc_gasto'];


$cod_estado_registro=1;

$sql=" select max(cod_gasto) from gastosTrabajo ";
$cod_gasto=obtenerCodigo($sql);


$sql="insert into gastosTrabajo set ";
$sql.=" cod_gasto='".$cod_gasto."',"; 
$sql.=" desc_gasto='".$desc_gasto."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."'"; 
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastos.php";
</script>