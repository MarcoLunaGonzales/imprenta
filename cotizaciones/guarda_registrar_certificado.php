<?php
require("conexion.inc");
include("funciones.php");

	$cod_empresa=$_POST['cod_empresa'];
	$cod_producto=$_POST['cod_producto'];
//	echo "cod_producto=".$cod_producto."<br>";
	$fecha_emision=$_POST['fecha_emision'];	
	if($fecha_emision<>""){
		$vector=explode("/",$fecha_emision);
		$fecha_emision=$vector[2]."-".$vector[1]."-".$vector[0];
	}
	$cod_ciudad=$_POST['cod_ciudad'];	
	$cod_usuario_firma=$_POST['cod_usuario_firma'];
	$fechaNow=date("Y-m-d H:i:s");
	$usuario_global=$_COOKIE['usuario_global'];
	$cod_estado_certificado=1;
	
	$fichasTecnicas=$_POST['fichasTecnicas'];
	//echo $fichasTecnicas."<br>";
	
	

	$sql="select max(cod_cert_prod) from certificados_producto";
	$cod_cert_prod=obtenerCodigo($sql);
	
	$sql=" insert into certificados_producto set ";
	$sql.=" cod_cert_prod='".$cod_cert_prod."',";
	$sql.=" cod_producto='".$cod_producto."',";
	$sql.=" cod_empresa='".$cod_empresa."',";
	$sql.=" modelo_certificacion='".$modelo_certificacion."',";
	$sql.=" cia_productora='".$cia_productora."',";
	$sql.=" cia_productora_bolivia='".$cia_productora_bolivia."',";
	$sql.=" fecha_emision='".$fecha_emision."',";
	$sql.=" cod_usuario_firma='".$cod_usuario_firma."',";
	$sql.=" cod_usuario_registro='".$usuario_global."',";
	$sql.=" fecha_usuario_registro='".$fechaNow."',";
	$sql.=" cod_usuario_modifica='".$usuario_global."',";
	$sql.=" fecha_usuario_modifica='".$fechaNow."',";
	$sql.=" cod_estado_certificado='".$cod_estado_certificado."',";
	$sql.=" cod_ciudad='".$cod_ciudad."'";
	//echo "sql=".$sql;
	mysql_query($sql);

	$vector2=explode(",",$fichasTecnicas);
	$n=sizeof($vector2);
	for($i=0;$i<$n;$i++){	
		$cod_ficha=$vector2[$i];
		$sql3=" insert into fichas_certificados_producto set ";
		$sql3.=" cod_cert_prod='".$cod_cert_prod."',";
		$sql3.=" cod_ficha='".$cod_ficha."'";
		$resp3=mysql_query($sql3);
	}	



require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	location.href="listaCertificadosEmpresas.php?cod_empresa=<?php echo $cod_empresa; ?>";
</script>