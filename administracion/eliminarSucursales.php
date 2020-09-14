<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_sucursal=$vector_datos[$i];
		$sql=" delete from sucursales where cod_sucursal='".$cod_sucursal."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorSucursales.php";
</script>
