<?php
require("conexion.inc");
include("funciones.php");
$desc_item=$_POST['desc_item'];
$cod_estado_registro=1;

$sql="select max(cod_item) from items ";
$cod_item=obtenerCodigo($sql);

$sql="insert into items set ";
$sql.=" cod_item='".$cod_item."', ";
$sql.=" desc_item='".$desc_item."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysql_query($sql);
require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorItems.php";
</script>