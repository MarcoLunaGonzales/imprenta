<?php
require("conexion.inc");
include("funciones.php");

$desc_maquina=$_POST['desc_maquina'];

$cod_estado_registro=$_POST['cod_estado_registro'];

$cod_estado_registro=1;


$sql=" select max(cod_maquina) from maquinaria ";
$cod_maquina=obtenerCodigo($sql);


$sql="insert into maquinaria set ";
$sql.=" cod_maquina=".$cod_maquina.","; 
$sql.=" desc_maquina='".$desc_maquina."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
//$sql.=" cod_usuario_modifica='".$obs_cargo."',";
//$sql.=" fecha_modifica='".$obs_cargo."'";
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorMaquinas.php";
</script>