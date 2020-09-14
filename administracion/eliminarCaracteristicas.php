<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_carac=$vector_datos[$i];
		$sql=" delete from caracteristicas where cod_carac='".$cod_carac."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorCaracteristicas.php";
</script>
