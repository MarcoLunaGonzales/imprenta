<?php
require("conexion.inc");
include("funciones.php");
$cod_grado=$_POST['cod_grado'];
$nombre_grado=$_POST['nombre_grado'];
$abrev_grado=$_POST['abrev_grado'];
$cod_estado_registro=$_POST['cod_estado_registro'];



$sql="update grados set ";
$sql.=" nombre_grado='".$nombre_grado."',";
$sql.=" abrev_grado='".$abrev_grado."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_grado='".$cod_grado."'";

$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegador_grados.php";
</script>