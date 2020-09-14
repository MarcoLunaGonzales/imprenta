<?php
require("conexion.inc");
include("funciones.php");

$sql="delete from gastos  where cod_gasto='".$_POST['cod_gasto']."'"; 
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastos.php";
</script>
