<?php
require("conexion.inc");
include("funciones.php");
$cod_item=$_POST['cod_item'];
$desc_item=$_POST['desc_item'];
$cod_estado_registro=$_POST['cod_estado_registro'];



$sql="update items set ";
$sql.=" desc_item='".$desc_item."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_item='".$cod_item."' ";
$resp=mysql_query($sql);
require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorItems.php";
</script>