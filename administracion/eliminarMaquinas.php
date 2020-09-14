<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_maquina=$vector_datos[$i];
		$sql=" delete from maquinaria where cod_maquina='".$cod_maquina."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorMaquinas.php";
</script>
