<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$cod_empresa=$_POST['cod_empresa'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_cert_prod=$vector_datos[$i];
		$sql=" delete from certificados_producto where cod_cert_prod='".$cod_cert_prod."'";
		mysql_query($sql);				
		$sql=" delete from fichas_certificados_producto where cod_cert_prod='".$cod_cert_prod."'";
		mysql_query($sql);	
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="listaCertificadosEmpresas.php?cod_empresa=<?php echo $cod_empresa;?>";
</script>
