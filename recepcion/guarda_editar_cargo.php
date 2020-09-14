<?php
require("conexion.inc");
include("funciones.php");
$cod_cargo=$_POST['cod_cargo'];
$nombre_cargo=$_POST['nombre_cargo'];
$obs_cargo=$_POST['obs_cargo'];
$cod_estado_registro=$_POST['cod_estado_registro'];



$sql="update cargos set ";
$sql.=" nombre_cargo='".$nombre_cargo."',";
$sql.=" obs_cargo='".$obs_cargo."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_cargo='".$cod_cargo."'";

$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegador_cargos.php";
</script>