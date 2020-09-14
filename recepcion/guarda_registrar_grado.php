<?php
require("conexion.inc");
include("funciones.php");
$nombre_grado=$_POST['nombre_grado'];
$abrev_grado=$_POST['abrev_grado'];
$cod_estado_registro=1;

$sql="select max(cod_grado) from grados";
$codigo=obtenerCodigo($sql);

$sql="insert into grados set ";
$sql.=" cod_grado='".$codigo."', ";
$sql.=" nombre_grado='".$nombre_grado."',";
$sql.=" abrev_grado='".$abrev_grado."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";

$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegador_grados.php";
</script>