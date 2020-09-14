<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datos'];
	$codItem=$_POST['codItem'];
	$codCompItem=$_POST['codCompItem'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$codCarac=$vector_datos[$i];
		$sql=" delete from componentes_caracteristica where cod_compitem='".$codCompItem."' and cod_carac=".$codCarac;
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorCompCarac.php?codItem="+<?php echo $codItem;?>+"&codComp="+<?php echo $codCompItem;?>;
</script>
