<?php
require("conexion.inc");
include("funciones.php");

$nombre_tipo_pago=$_POST['nombre_tipo_pago'];
$obs_tipo_pago=$_POST['obs_tipo_pago'];

$cod_estado_registro=$_POST['cod_estado_registro'];

$cod_estado_registro=1;



$sql=" select max(cod_tipo_pago) from tipos_pago ";
$cod_tipo_pago=obtenerCodigo($sql);


$sql="insert into tipos_pago set ";
$sql.=" cod_tipo_pago=".$cod_tipo_pago.","; 
$sql.=" nombre_tipo_pago='".$nombre_tipo_pago."',"; 
$sql.=" obs_tipo_pago='".$obs_tipo_pago."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
//$sql.=" cod_usuario_modifica='".$obs_cargo."',";
//$sql.=" fecha_modifica='".$obs_cargo."'";
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorTiposPago.php";
</script>