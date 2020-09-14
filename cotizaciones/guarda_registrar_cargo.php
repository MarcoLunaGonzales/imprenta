<?php
require("conexion.inc");
include("funciones.php");
$nombre_cargo=$_POST['nombre_cargo'];
$obs_cargo=$_POST['obs_cargo'];
$cod_estado_registro=1;

$sql="select max(cod_cargo) from cargos";
$codigo=obtenerCodigo($sql);

$sql="insert into cargos set ";
$sql.=" cod_cargo='".$codigo."', ";
$sql.=" nombre_cargo='".$nombre_cargo."',";
$sql.=" obs_cargo='".$obs_cargo."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";

$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegador_cargos.php";
</script>