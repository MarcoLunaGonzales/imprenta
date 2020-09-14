<?php
require("conexion.inc");
include("funciones.php");

$sql="update gastos set ";
$sql.=" desc_gasto='".$_POST['desc_gasto']."',"; 
$sql.=" cod_estado_registro='".$_POST['cod_estado_registro']."',";
$sql.=" obs_gasto='".$_POST['obs_gasto']."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_gasto='".$_POST['cod_gasto']."'"; 
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastos.php";
</script>
