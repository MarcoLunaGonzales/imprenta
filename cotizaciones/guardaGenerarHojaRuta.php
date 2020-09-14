<?php
require("conexion.inc");
include("funciones.php");

$cod_cotizacion = $_POST['cod_cotizacion'];
$obs_hoja_ruta = $_POST['obs_hoja_ruta'];
$cod_usuario_comision = $_POST['cod_usuario_comision'];
$factura_si_no = $_POST['factura_si_no'];
$cod_tipo_pago=$_POST['cod_tipo_pago'];


$sql = "select max(cod_hoja_ruta) from hojas_rutas";
$cod_hoja_ruta = obtenerCodigo($sql);

$fecha_hoja_ruta=date('Y/m/d h:i:s', time());

$cod_gestion=gestionActiva();	
$sql="select max(nro_hoja_ruta) from hojas_rutas where cod_gestion='".$cod_gestion."'";
$nro_hoja_ruta=obtenerCodigo($sql);
	



$sql=" insert into hojas_rutas set  ";
$sql.=" cod_hoja_ruta='".$cod_hoja_ruta."',";
$sql.=" cod_gestion='".$cod_gestion."',";
$sql.=" nro_hoja_ruta='".$nro_hoja_ruta."',";
$sql.=" fecha_hoja_ruta='".$fecha_hoja_ruta."',";
$sql.=" cod_usuario_hoja_ruta='".$_COOKIE['usuario_global']."',";
$sql.=" obs_hoja_ruta='".$obs_hoja_ruta."', ";
$sql.=" cod_cotizacion='".$cod_cotizacion."',";
$sql.=" cod_estado_hoja_ruta=1, ";
$sql.=" factura_si_no='".$factura_si_no."',";
$sql.=" cod_tipo_pago='".$cod_tipo_pago."',";
$sql.=" cod_usuario_comision='".$cod_usuario_comision."',";
if($cod_tipo_pago==3){
	$sql.=" cod_estado_pago_doc=3";
}else{
	$sql.=" cod_estado_pago_doc=1";
}
//echo $sql."<br>";
mysql_query($sql);


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



///CREACION DE CUENTA////
	$sql3=" select cod_cliente from cotizaciones where cod_cotizacion=".$_POST['cod_cotizacion'];
	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cliente=$dat3['cod_cliente'];
	}
	$sql3="select  nombre_cliente from clientes where cod_cliente=".$cod_cliente;

	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$nombre_cliente=$dat3['nombre_cliente'];		
	}	
		$sql3=" select  cod_cuenta_conf,parametro1,parametro2 ";
	$sql3.=" from configuracion_cuentas where cod_conf_cuenta=1";
	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cuenta_conf=$dat3['cod_cuenta_conf'];
		$parametro1=$dat3['parametro1'];
		$parametro2=$dat3['parametro2'];
	}	
	$sql3=" select  cod_cuenta_padre from cuentas where cod_cuenta=".$cod_cuenta_conf;
	echo $sql3;
	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cuenta_padre_conf=$dat3['cod_cuenta_padre'];
	}		
	$fechaFinal=date('Y-m-d', time());
//echo "parametro2=".$parametro2."<br/>";
	$fechaInicio=date('Y-m-d', strtotime(-$parametro2."month"));
		echo "$fechaInicio=".$fechaInicio."<br/>";
			echo "$fechaFinal=".$fechaFinal."<br/>";

	$sql3=" select  cli.cod_cuenta,cuentas.nro_cuenta,cuentas.desc_cuenta,";
	$sql3.=" clientesVal.nroVTA, clientesVal.nroHR, clientesVal.nroOT, ";
	$sql3.=" (clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT) as nroDoc";
	$sql3.=" FROM(select cod_cliente,SUM(nroHR) as nroHR,SUM(nroOT) as nroOT,SUM(nroVTA) as nroVTA ";
	$sql3.=" from (select c.cod_cliente,count(*) as nroHR, 0 as nroOT, 0 as nroVTA ";
	$sql3.="  from  hojas_rutas hr inner join cotizaciones c ";
	$sql3.="  ON( hr.cod_cotizacion=c.cod_cotizacion and  hr.cod_estado_hoja_ruta<>2)";
	$sql3.=" and fecha_hoja_ruta>='".$fechaInicio."' and fecha_hoja_ruta<='".$fechaFinal."'";
 	$sql3.=" group by c.cod_cliente ";
	$sql3.="  UNION ";
	$sql3.=" select cod_cliente, 0 as nroHR, COUNT(*) as nroOT, 0 as nroVTA";
	$sql3.=" from ordentrabajo where cod_est_ot<>2 ";
	$sql3.=" and fecha_orden_trabajo>='".$fechaInicio."' and fecha_orden_trabajo<='".$fechaFinal."'";
	$sql3.=" group by cod_cliente ";
	$sql3.="  UNION ";
	$sql3.=" select cod_cliente_venta as cod_cliente, 0 as nroHR, 0 as nroOT, COUNT(*) as nroVTA";
	$sql3.=" from  salidas where cod_tipo_salida=1  and cod_estado_salida<>2  ";
	$sql3.=" and fecha_salida>='".$fechaInicio."' and fecha_salida<='".$fechaFinal."'";
	$sql3.="  group by cod_cliente) as clientesValidos ";
	$sql3.=" GROUP BY cod_cliente) as clientesVal  INNER join clientes cli ON(clientesVal.cod_cliente=cli.cod_cliente) ";
	$sql3.=" LEFT JOIN cuentas  on (cli.cod_cuenta=cuentas.cod_cuenta) ";
	$sql3.=" where cli.cod_cliente=".$cod_cliente;
//	echo $sql3."<br/>";
	$resp3 = mysql_query($sql3);
	$cod_cuenta=NULL;
	$nro_cuenta="";
	$desc_cuenta="";
	$nroVTA=0;
	$nroHR=0;
	$nroOT=0;
	$nroDoc=0;
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cuenta=$dat3['cod_cuenta'];
		$nro_cuenta=$dat3['nro_cuenta'];
		$desc_cuenta=$dat3['desc_cuenta'];
	 	$nroVTA=$dat3['nroVTA'];
		$nroHR=$dat3['nroHR'];
		$nroOT=$dat3['nroOT'];
		$nroDoc=$dat3['nroDoc'];
	}
//echo "nroDoc=".$nroDoc;
	if($nroDoc>=$parametro1){
			if(($cod_cuenta==$cod_cuenta_conf) or ($cod_cuenta==NULL or $cod_cuenta=="" )){
				$sql=" select max(cod_cuenta) from cuentas ";
				$cod_cuenta_nueva=obtenerCodigo($sql);
		
				$sql="insert into cuentas set ";
				$sql.=" cod_cuenta='".$cod_cuenta_nueva."',"; 
				$sql.=" nro_cuenta=0,"; 
				$sql.=" desc_cuenta='".$nombre_cliente."',"; 
				$sql.=" cod_moneda='1',"; 
				$sql.=" cod_cuenta_padre=".$cod_cuenta_padre_conf.","; 
				$sql.=" cod_estado_registro=1,"; 
				$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
				$sql.=" fecha_registro='".date('Y-m-d H:i:s', time())."'";
				mysql_query($sql);
				$sql=" update clientes set ";
				$sql.=" cod_cuenta=".$cod_cuenta_nueva;
				$sql.=" where cod_cliente=".$cod_cliente;
				mysql_query($sql);		
			}
	}else{
		if($cod_cuenta==NULL or $cod_cuenta=="" ){
			$sql=" update clientes set ";
			$sql.=" cod_cuenta=".$cod_cuenta_conf;
			$sql.=" where cod_cliente=".$cod_cliente;
			mysql_query($sql);
		}
	
	}

	
			/*$dt_Ayer= date('Y-m-d', strtotime('-1 day')) ; // resta 1 día
$dt_laSemanaPasada = date('Y-m-d', strtotime('-1 week')) ; // resta 1 semana
$dt_elMesPasado = date('Y-m-d', strtotime('-1 month')) ; // resta 1 mes
$dt_ElAnioPasado = date('Y-m-d', strtotime('-1 year')) ; // resta 1 año
//Mostrar fechas
echo $dt_Ayer;
echo $dt_laSemanaPasada;
echo $dt_elMesPasado;
echo $dt_ElAnioPasado;
*/

		
	
	
?>

<script language="JavaScript">				
	location.href="listHojasRutas.php";
</script>
