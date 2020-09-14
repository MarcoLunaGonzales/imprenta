<?php
require("conexion.inc");
include("funciones.php");

$desc_cargo=$_POST['desc_cargo'];
$obs_cargo=$_POST['obs_cargo'];

$cod_estado_registro=$_POST['cod_estado_registro'];

$cod_estado_registro=1;

$sql=" select max(cod_cargo) from cargos ";
$cod_cargo=obtenerCodigo($sql);


$sql="insert into cargos set ";
$sql.=" cod_cargo='".$cod_cargo."',"; 
$sql.=" desc_cargo='".$desc_cargo."',"; 
$sql.=" obs_cargo='".$obs_cargo."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorCargos.php";
</script>