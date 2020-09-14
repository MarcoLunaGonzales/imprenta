<?php 
require("conexion.inc");

	$cod_grupo=$_POST['cod_grupo'];
	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_subgrupo=$vector_datos[$i];
		$sql=" delete from subgrupos where cod_subgrupo='".$cod_subgrupo."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorSubGrupos.php?cod_grupo=<?php echo $cod_grupo;?>";
</script>
