<?php
require("conexion.inc");
include("funciones.php");

	$fecha_tipo_cambio=$_POST['fecha_tipo_cambio'];
	$cod_moneda=$_POST['cod_moneda'];
	
	$sql="update tipo_cambio set ";
	$sql.=" cambio_bs='".$_POST['cambio_bs']."'"; 
	$sql.=" where fecha_tipo_cambio='".strftime("%Y-%m-%d",strtotime($fecha_tipo_cambio))."'"; 	
	$sql.=" and cod_moneda='".$cod_moneda."'"; 	
	mysql_query($sql);
	
	


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listTipoCambio.php";
</script>