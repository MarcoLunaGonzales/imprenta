<?php
require("conexion.inc");
include("funciones.php");

$cod_cotizacion = $_POST['cod_cotizacion'];
$datos = $_POST['datos'];

$sql = "select max(cod_hoja_ruta) from hojas_rutas";
$cod_hoja_ruta = obtenerCodigo($sql);



$fecha_hoja_ruta=date('Y/m/d h:i:s', time());

$sql=" insert into hojas_rutas set  ";
$sql.=" cod_hoja_ruta='".$cod_hoja_ruta."',";
$sql.=" cod_cotizacion='".$cod_cotizacion."',";
$sql.=" fecha_hoja_ruta='".$fecha_hoja_ruta."',";
$sql.=" cod_estado_hoja_ruta=1, ";
$sql.=" cod_usuario_hoja_ruta='".$_COOKIE['usuario_global']."'";
mysql_query($sql);

$sql=" update cotizaciones set  ";
$sql.=" cod_estado_cotizacion=3";
$sql.="  where cod_cotizacion='".$cod_cotizacion."'";
mysql_query($sql);


	$vector_datos=explode(",",$datos);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_cotizaciondetalle=$vector_datos[$i];
		$sql=" update cotizaciones_detalle set ";
		$sql.=" cod_estado_detallecotizacionitem=2 ";
		$sql.=" where cod_cotizacion='".$cod_cotizacion."'";
		$sql.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
		mysql_query($sql);				
	}	
	

?>
<script language="JavaScript">				
	location.href="generarHojaRutaPasoII.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>";
</script>
