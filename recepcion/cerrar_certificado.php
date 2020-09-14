<?php 
	require("conexion.inc");

	$cod_cert_prod=$_GET['cod_cert_prod'];
	$usuario_global=$_COOKIE['usuario_global'];
	$fechaNow=date("Y-m-d h:i:s");
	$cod_empresa=$_GET['cod_empresa'];
	
	$sql="update certificados_producto set ";
	$sql.=" cod_usuario_cierra='".$usuario_global."',";
	$sql.=" fecha_cierra='".$fechaNow."',";	
	$sql.=" cod_estado_certificado=2 ";
	$sql.=" where cod_cert_prod='".$cod_cert_prod."'";
	//echo $sql;
	$resp=mysql_query($sql);
	
	 require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="listaCertificadosEmpresas.php?cod_empresa=<?php echo $cod_empresa;?>";
</script>
