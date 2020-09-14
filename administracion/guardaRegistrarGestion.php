<?php
require("conexion.inc");
include("funciones.php");
$gestion=$_POST['gestion'];


$sql="select max(cod_gestion) from gestiones";
$cod_gestion=obtenerCodigo($sql);

$sql="insert into gestiones set ";
$sql.=" cod_gestion='".$cod_gestion."', ";
$sql.=" gestion='".$gestion."',";
$sql.=" gestion_nombre='".$_POST['gestion_nombre']."',";
$sql.=" gestion_activa=0";
$resp=mysql_query($sql);
//echo $sql;
require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorGestiones.php";
</script>