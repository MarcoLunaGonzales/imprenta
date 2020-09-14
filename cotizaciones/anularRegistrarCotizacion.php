<?php
require("conexion.inc");
include("funciones.php");

$codCotizacion=$_GET['codCotizacion'];
$sql = "update cotizaciones set COD_ESTADO_COTIZACION=2";
$sql .= " where cod_cotizacion=" .$codCotizacion. "";
mysql_query($sql);
?>
<script language="JavaScript">				
		location.href="listCotizaciones.php";
</script>
