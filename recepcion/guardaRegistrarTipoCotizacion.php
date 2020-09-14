<?php
require("conexion.inc");
include("funciones.php");

$nombre_tipo_cotizacion=$_POST['nombre_tipo_cotizacion'];
$obs_tipo_cotizacion=$_POST['obs_tipo_cotizacion'];

$cod_estado_registro=$_POST['cod_estado_registro'];

$cod_estado_registro=1;



$sql=" select max(cod_tipo_cotizacion) from tipos_cotizacion ";
$cod_tipo_cotizacion=obtenerCodigo($sql);


$sql="insert into tipos_cotizacion set ";
$sql.=" cod_tipo_cotizacion=".$cod_tipo_cotizacion.","; 
$sql.=" nombre_tipo_cotizacion='".$nombre_tipo_cotizacion."',"; 
$sql.=" obs_tipo_cotizacion='".$obs_tipo_cotizacion."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
//$sql.=" cod_usuario_modifica='".$obs_cargo."',";
//$sql.=" fecha_modifica='".$obs_cargo."'";
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorTiposCotizacion.php";
</script>