<?php
require("conexion.inc");
include("funciones.php");
$desc_carac=$_POST['desc_carac'];
$cod_estado_registro=1;

$sql="select max(cod_carac) from caracteristicas ";
$cod_carac=obtenerCodigo($sql);

$sql="insert into caracteristicas set ";
$sql.=" cod_carac='".$cod_carac."', ";
$sql.=" desc_carac='".$desc_carac."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";

$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorCaracteristicas.php";
</script>