<?php
require("conexion.inc");
include("funciones.php");

$desc_banco=$_POST['desc_banco'];


$cod_estado_registro=1;



$sql=" select max(cod_banco) from bancos ";
$cod_banco=obtenerCodigo($sql);


$sql="insert into bancos set ";
$sql.=" cod_banco=".$cod_banco.","; 
$sql.=" desc_banco='".$desc_banco."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
//$sql.=" cod_usuario_modifica='".$obs_cargo."',";
//$sql.=" fecha_modifica='".$obs_cargo."'";
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorBancos.php";
</script>