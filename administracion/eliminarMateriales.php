<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_material=$vector_datos[$i];
		$sql=" delete from materiales_grupos_caracteristicas where cod_material='".$cod_material."'";
		mysql_query($sql);	
		$sql=" delete from materiales where cod_material='".$cod_material."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorMateriales.php";
</script>
