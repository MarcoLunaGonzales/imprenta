<?php
require("conexion.inc");
include("funciones.php");

$cod_gestion=$_GET['cod_gestion'];




$sql="update gestiones set ";
$sql.=" gestion_activa=0 ";
$resp=mysql_query($sql);


$sql="update gestiones set ";
$sql.=" gestion_activa=1 ";
$sql.=" where cod_gestion='".$cod_gestion."'";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorGestiones.php";
</script>