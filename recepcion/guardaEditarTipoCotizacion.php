<?php
require("conexion.inc");
include("funciones.php");

$cod_tipo_cotizacion=$_POST['cod_tipo_cotizacion'];
$nombre_tipo_cotizacion=$_POST['nombre_tipo_cotizacion'];
$obs_tipo_cotizacion=$_POST['obs_tipo_cotizacion'];
$cod_estado_registro=$_POST['cod_estado_registro'];



$sql="update tipos_cotizacion set ";
$sql.=" nombre_tipo_cotizacion='".$nombre_tipo_cotizacion."',"; 
$sql.=" obs_tipo_cotizacion='".$obs_tipo_cotizacion."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_tipo_cotizacion=".$cod_tipo_cotizacion.""; 

mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorTiposCotizacion.php";
</script>