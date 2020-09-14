<?php 
require("conexion.inc");

	$cod_grupo=$_POST['cod_grupo'];
	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_grupo_carac=$vector_datos[$i];
		$sql=" delete from grupos_caracteristicas where cod_grupo_carac='".$cod_grupo_carac."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorGruposCaracteristicas.php?cod_grupo=<?php echo $cod_grupo;?>";
</script>
