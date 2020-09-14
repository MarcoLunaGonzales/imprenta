<?php
require("conexion.inc");
include("funciones.php");
$cod_carac=$_POST['cod_carac'];
$desc_carac=$_POST['desc_carac'];
$cod_estado_registro=$_POST['cod_estado_registro'];

$sql="update caracteristicas set ";
$sql.=" desc_carac='".$desc_carac."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_carac='".$cod_carac."' ";
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorCaracteristicas.php";
</script>