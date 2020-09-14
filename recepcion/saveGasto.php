<?php
require("conexion.inc");
include("funciones.php");


$cod_estado_registro=1;

$sql=" select max(cod_gasto) from gastos ";
$cod_gasto=obtenerCodigo($sql);


$sql="insert into gastos set ";
$sql.=" cod_gasto='".$cod_gasto."',"; 
$sql.=" desc_gasto='".$_POST['desc_gasto']."',"; 
$sql.=" obs_gasto='".$_POST['obs_gasto']."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."'"; 
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastos.php";
</script>