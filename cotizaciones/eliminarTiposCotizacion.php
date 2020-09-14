<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_tipo_cotizacion=$vector_datos[$i];
		$sql=" delete from tipos_cotizacion where cod_tipo_cotizacion='".$cod_tipo_cotizacion."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorTiposCotizacion.php";
</script>
