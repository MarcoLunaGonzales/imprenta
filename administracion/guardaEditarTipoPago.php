<?php
require("conexion.inc");
include("funciones.php");

$cod_tipo_pago=$_POST['cod_tipo_pago'];
$nombre_tipo_pago=$_POST['nombre_tipo_pago'];
$obs_tipo_pago=$_POST['obs_tipo_pago'];
$cod_estado_registro=$_POST['cod_estado_registro'];



$sql="update tipos_pago set ";
$sql.=" nombre_tipo_pago='".$nombre_tipo_pago."',"; 
$sql.=" obs_tipo_pago='".$obs_tipo_pago."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_tipo_pago=".$cod_tipo_pago.""; 

mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorTiposPago.php";
</script>