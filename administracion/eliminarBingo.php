<?php
require("conexion.inc");
include("funciones.php");

$sql=" delete from bingo_detalle ";
mysql_query($sql);
$sql=" delete from bingo ";
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listBingo.php";
</script>