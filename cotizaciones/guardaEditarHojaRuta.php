<?php
require("conexion.inc");
include("funciones.php");

$cod_hoja_ruta = $_POST['cod_hoja_ruta'];
$obs_hoja_ruta = $_POST['obs_hoja_ruta'];
$cod_usuario_comision = $_POST['cod_usuario_comision'];
$factura_si_no = $_POST['factura_si_no'];
$cod_tipo_pago = $_POST['cod_tipo_pago'];



//$fecha_hoja_ruta=date('Y/m/d h:i:s', time());
$nro_pagos=0;
$sql=" select count(*) ";
$sql.=" from pagos_detalle pd, pagos p ";
$sql.=" where pd.codigo_doc=".$cod_hoja_ruta;
$sql.=" and pd.cod_tipo_doc=2";
$sql.=" and pd.cod_pago=p.cod_pago ";
$sql.=" and p.cod_estado_pago<>2 ";
$resp=mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	$nro_pagos=$dat[0];
}


$sql=" update  hojas_rutas set  ";
$sql.=" obs_hoja_ruta='".$obs_hoja_ruta."', ";
$sql.=" cod_estado_hoja_ruta=1, ";
$sql.=" factura_si_no='".$factura_si_no."',";
$sql.=" cod_usuario_comision='".$cod_usuario_comision."',";
$sql.=" cod_tipo_pago='".$cod_tipo_pago."',";
if($nro_pagos==0){
	if($cod_tipo_pago==3){
		$sql.=" cod_estado_pago_doc=3,";
	}else{
		$sql.=" cod_estado_pago_doc=1,";
	}
}
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_modifica='".date('Y-m-d H:i:s', time())."'";
$sql.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";

mysql_query($sql);

	$sql=" select   cod_cotizacion from hojas_rutas  where cod_hoja_ruta='".$cod_hoja_ruta."'";
	$resp= mysql_query($sql);
	$dat=mysql_fetch_array($resp);
	$cod_cotizacion=$dat[0]; 
	
	


$vectorCotizacionDetalle = $_POST['vectorCotizacionDetalle'];
//echo "Vector Cotizacion Detalle".$vectorCotizacionDetalle."<br>";
$vectorUsuariosDiseno = $_POST['vectorUsuariosDiseno'];
//echo "Vector  vectorUsuariosDiseno".$vectorUsuariosDiseno."<br>";
$vectorDiseno = $_POST['vectorDiseno'];
//echo "Vector Cotizacion vectorDiseno".$vectorDiseno."<br>";
$vectorDisenoAprobadoPor = $_POST['vectorDisenoAprobadoPor'];
//echo "Vector  vectorDisenoAprobadoPor".$vectorDisenoAprobadoPor."<br>";
$vectorPlacas = $_POST['vectorPlacas'];
//echo "Vector  vectorPlacas".$vectorPlacas."<br>";
$vectorCantidad = $_POST['vectorCantidad'];
//echo "Vector vectorCantidad".$vectorCantidad."<br>";
$vectorMaquinaria = $_POST['vectorMaquinaria'];
//echo "Vector vectorMaquinaria".$vectorMaquinaria."<br>";
$vectorObservaciones = $_POST['vectorObservaciones'];
//echo "Vector vectorObservaciones".$vectorObservaciones."<br>";

	
$vectorCotizacionDetalle_2=explode(",",$vectorCotizacionDetalle);
$vectorUsuariosDiseno_2=explode(",",$vectorUsuariosDiseno);
$vectorDiseno_2=explode(",",$vectorDiseno);
$vectorDisenoAprobadoPor_2=explode(",",$vectorDisenoAprobadoPor);
$vectorPlacas_2=explode(",",$vectorPlacas);
$vectorCantidad_2=explode(",",$vectorCantidad);
$vectorMaquinaria_2=explode(",",$vectorMaquinaria);
$vectorObservaciones_2=explode(",",$vectorObservaciones);	
$n=sizeof($vectorCotizacionDetalle_2);	
	


$sql=" delete from hojas_rutas_detalle_maquinaria where cod_hoja_ruta='".$cod_hoja_ruta."'";

mysql_query($sql);
$sql=" delete from hojas_rutas_detalle where cod_hoja_ruta='".$cod_hoja_ruta."'";
mysql_query($sql);		
		
	for($i=0;$i<$n;$i++){	
			
		$sql= " insert into hojas_rutas_detalle set ";
		$sql.=" cod_hoja_ruta='".$cod_hoja_ruta."',";
		$sql.=" cod_cotizacion='".$cod_cotizacion."',";
		$sql.=" cod_cotizaciondetalle='".$vectorCotizacionDetalle_2[$i]."',";
		$sql.=" cod_usuario_diseno='".$vectorUsuariosDiseno_2[$i]."',";
		$sql.=" obs_trabajo='".$vectorObservaciones_2[$i]."',";
		$sql.=" diseno='".$vectorDiseno_2[$i]."',";
		$sql.=" diseno_aprobacion='".$vectorDisenoAprobadoPor_2[$i]."',";
		$sql.=" placas='".$vectorPlacas_2[$i]."',";
		$sql.=" cantidad_cpt='".$vectorCantidad_2[$i]."'";
		//echo "sql=".$sql."<br>";
		mysql_query($sql);

	
		$vectorMaquinaria_3=explode("|",$vectorMaquinaria_2[$i]);
		$longitud=sizeof($vectorMaquinaria_3);	
		//echo "longitud=".$longitud."<br>";
		for($j=0;$j<$longitud-1;$j++){
			
			$sql=" insert into hojas_rutas_detalle_maquinaria set ";
			$sql.=" cod_hoja_ruta='".$cod_hoja_ruta."',";
			$sql.=" cod_cotizacion='".$cod_cotizacion."',";
			$sql.=" cod_cotizaciondetalle='".$vectorCotizacionDetalle_2[$i]."',";
			$sql.=" cod_maquina='".$vectorMaquinaria_3[$j]."'";
			//echo "sql=".$sql."<br>";
			mysql_query($sql);
		}

	}	
?>
<script language="JavaScript">				
	location.href="listHojasRutas.php";
</script>
