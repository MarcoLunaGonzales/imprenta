<?php

header("Cache-Control: no-store, no-cache, must-revalidate");



require("conexion.inc");
include("funciones.php");
	
$cod_gestion=gestionActiva();
	
$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
$resp2= mysql_query($sql2);
$gestion="";
while($dat2=mysql_fetch_array($resp2)){
	$gestion=$dat2['gestion'];
}
	$sql="select max(nro_cbte) from comprobante where cod_gestion='".$cod_gestion."' and cod_tipo_cbte=".$_GET['cod_tipo_cbte'];
	$nro_cbte=obtenerCodigo($sql);

		echo $nro_cbte."/".$gestion;	
?>
	

