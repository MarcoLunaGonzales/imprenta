<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_grado=$vector_datos[$i];
		$sql=" delete from grados where cod_grado='".$cod_grado."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegador_grados.php";
</script>
