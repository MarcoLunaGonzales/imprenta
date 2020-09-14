<?php
require("conexion.inc");
include("funciones.php");

$desc_carac=$_POST['desc_carac'];

$cod_estado_registro=$_POST['cod_estado_registro'];

$cod_estado_registro=1;



$sql=" select max(cod_carac) from caracteristicas ";
$cod_carac=obtenerCodigo($sql);


$sql="insert into caracteristicas set ";
$sql.=" cod_carac=".$cod_carac.","; 
$sql.=" desc_carac='".$desc_carac."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
//$sql.=" cod_usuario_modifica='".$obs_cargo."',";
//$sql.=" fecha_modifica='".$obs_cargo."'";

mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorCaracteristicas.php";
</script>