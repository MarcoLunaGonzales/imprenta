<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_categoria=$vector_datos[$i];
		$sql=" delete from clientes_categorias where cod_categoria='".$cod_categoria."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorClientesCategorias.php";
</script>
