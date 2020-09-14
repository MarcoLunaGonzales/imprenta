<?php
require("conexion.inc");
include("funciones.php");

$cod_maquina=$_POST['cod_maquina'];
$desc_maquina=$_POST['desc_maquina'];

$cod_estado_registro=$_POST['cod_estado_registro'];



$sql="update maquinaria set ";
$sql.=" desc_maquina='".$desc_maquina."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_maquina=".$cod_maquina.""; 

mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorMaquinas.php";
</script>