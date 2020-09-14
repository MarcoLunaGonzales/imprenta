<?php
require("conexion.inc");
include("funciones.php");

	$cod_pago=$_POST['cod_pago'];
	//echo $_POST['fecha_pago'];
		$vectorFechaPago = explode("/", $_POST['fecha_pago']);
	$fechaPago = $vectorFechaPago[2] . "-" . $vectorFechaPago[1] . "-" . $vectorFechaPago[0];
	$sql="update pagos set ";
	$sql.=" obs_pago='".$_POST['obs_pago']."',"; 
	$sql.=" total_bs='".$_POST['total_bs']."',"; 
	$sql.=" fecha_pago='".$fechaPago."',"; 
	$sql.=" fecha_modifica='".date('Y-m-d', time())."',"; 
	$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."'"; 
	$sql.=" where cod_pago='".$_POST['cod_pago']."'"; 	
	mysql_query($sql);
	
	$sql="select cod_cliente from pagos where cod_pago='".$_POST['cod_pago']."'"; 
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		 $cod_cliente=$dat['cod_cliente'];
	}
	
	///////////////////////ACTUALIZACION DE ESTADOS ///////////////////////
	$sql=" select codigo_doc ";
	$sql.=" from pagos_detalle ";
	$sql.=" where cod_pago=".$_POST['cod_pago'];
	$sql.=" and cod_tipo_doc=1";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		 $cod_hoja_ruta=$dat['codigo_doc'];
	
	$monto_hojaruta=0;
	$sql2=" select sum(cd.IMPORTE_TOTAL) ";
	$sql2.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
	$sql2.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
    $sql2.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
	$sql2.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
	$resp2 = mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$monto_hojaruta=$dat2[0];
    }
	//////////////////////////
	$descuento_cotizacion=0;
	$sql2=" select c.descuento_cotizacion ";
	$sql2.=" from hojas_rutas hr, cotizaciones c ";
	$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
	$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
	$resp2 = mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$descuento_cotizacion=$dat2['descuento_cotizacion'];
	}
	///////////////////////////
	$incremento_cotizacion=0;
	$sql2=" select c.incremento_cotizacion ";
	$sql2.=" from hojas_rutas hr, cotizaciones c ";
	$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
	$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
	$resp2 = mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$incremento_cotizacion=$dat2['incremento_cotizacion'];
	}
	///////////////////////////	
	$monto_hojaruta=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;	
	$sql2=" select  pd.monto_pago_detalle ";
	$sql2.=" from pagos_detalle pd, pagos p";
	$sql2.=" where pd.cod_pago=p.cod_pago";
	$sql2.=" and p.cod_estado_pago<>2";
	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
	$sql2.=" and cod_tipo_doc=1";
	$sql2.=" and pd.cod_pago<>".$cod_pago;

	$resp2 = mysql_query($sql2);
	$acuenta_hojaruta=0;
	while($dat2=mysql_fetch_array($resp2)){
					
					$monto_pago_detalle=$dat2['monto_pago_detalle'];					
					$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
		}				

		if($acuenta_hojaruta==0){
				$sql4=" update hojas_rutas set ";
				$sql4.=" cod_estado_pago_doc=1";
				$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;	
				
				mysql_query($sql4);
		 }else{
		 	 if(($monto_hojaruta-$acuenta_hojaruta)>0){
					$sql4=" update hojas_rutas set ";
					$sql4.=" cod_estado_pago_doc=2";
					$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;	
					mysql_query($sql4);
			 }
			 if(($monto_hojaruta-$acuenta_hojaruta)==0){
					$sql4=" update hojas_rutas set ";
					$sql4.=" cod_estado_pago_doc=3";
					$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;	
					mysql_query($sql4);
			 }
		 }

		///////////////////////FIN ACTUALIZACION DE ESTADOS ///////////////////////
	}

	$sql="delete from pagos_detalle where cod_pago=".$cod_pago." and cod_tipo_doc=1";
	mysql_query($sql);
///////////////////////////////////////////////
	$sql=" select hr.cod_hoja_ruta,hr. nro_hoja_ruta, hr.cod_gestion, g.gestion,  hr.fecha_hoja_ruta, hr.cod_cotizacion ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$cod_cliente;
	$sql.=" and hr.cod_estado_hoja_ruta<>2";
	$sql.=" and hr.cod_estado_pago_doc<>3";
	$sql.=" order by hr.fecha_hoja_ruta asc , nro_hoja_ruta asc  ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_hoja_ruta=$dat['cod_hoja_ruta'];
		 $nro_hoja_ruta=$dat['nro_hoja_ruta'];
		 $cod_gestion=$dat['cod_gestion'];
		 $gestion=$dat['gestion'];
		 $fecha_hoja_ruta=$dat['fecha_hoja_ruta'];
		 $cod_cotizacion=$dat['cod_cotizacion'];
		 
		 if($_POST['cod_hoja_ruta'.$cod_hoja_ruta]){
			 
			 $saldo_hojaruta=$_POST['saldo_hojaruta'.$cod_hoja_ruta];
			 $monto_pago_detalle=$_POST['monto_pago_hr'.$cod_hoja_ruta];	
 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_hoja_ruta."',";
			 $sql2.=" cod_tipo_doc=1,";			 
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."'";
	 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE HOJAS DE RUTAS////////////
			 
					$monto_pago_detalle_bs=0;
						$monto_pago_detalle_bs=$monto_pago_detalle;

					
					$saldo_actual=$saldo_hojaruta-$monto_pago_detalle_bs;
					if($saldo_actual<=0){
						$sql4=" update hojas_rutas set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;
						mysql_query($sql4);
					}else{
						$sql4=" update hojas_rutas set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;		
						mysql_query($sql4);				
					}
					
			///////////////////// FIN ACTUALIZAR ESTADO DE PAGO DE HOJAS DE RUTAS////////////

		 }
		 
	}

					


///////////////////////////////PROCESO PARA ORDENES DE TRABAJO////////////////////////
///////////////////////ACTUALIZACION DE ESTADOS ///////////////////////
	$sql=" select codigo_doc ";
	$sql.=" from pagos_detalle ";
	$sql.=" where cod_pago=".$_POST['cod_pago'];
	$sql.=" and cod_tipo_doc=2";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		 $cod_orden_trabajo=$dat['codigo_doc'];
	
	$monto_orden_trabajo=0;
	$sql2=" select sum(monto_orden_trabajo) ";
	$sql2.=" from ordentrabajo ";
	$sql2.=" where cod_orden_trabajo=".$cod_orden_trabajo;
	$resp2 = mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$monto_orden_trabajo=$dat2[0];
    }

	$sql2=" select pd.monto_pago_detalle ";
	$sql2.=" from pagos_detalle pd, pagos p";
	$sql2.=" where pd.cod_pago=p.cod_pago";
	$sql2.=" and p.cod_estado_pago<>2";
	$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
	$sql2.=" and pd.cod_tipo_doc=2";
	$sql2.=" and pd.cod_pago<>".$_POST['cod_pago'];
	$resp2 = mysql_query($sql2);
	$acuenta_ordentrabajo=0;
	while($dat2=mysql_fetch_array($resp2)){
					
					$monto_pago_detalle=$dat2['monto_pago_detalle'];					
					$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;					
		}				

		if($acuenta_ordentrabajo==0){
				$sql4=" update ordentrabajo set ";
				$sql4.=" cod_estado_pago_doc=1";
				$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;	
				//echo $sql4."<br/>";		
				mysql_query($sql4);
		 }else{
		 	 if(($monto_orden_trabajo-$acuenta_ordentrabajo)>0){
					$sql4=" update ordentrabajo set ";
					$sql4.=" cod_estado_pago_doc=2";
					$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;
				//	echo $sql4."<br/>";	
					mysql_query($sql4);
			 }
			 if(($monto_orden_trabajo-$acuenta_ordentrabajo)==0){
					$sql4=" update ordentrabajo set ";
					$sql4.=" cod_estado_pago_doc=3";
					$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;	
				//	echo $sql4."<br/>";
					mysql_query($sql4);
			 }
		 }

		///////////////////////FIN ACTUALIZACION DE ESTADOS ///////////////////////
	}

	$sql="delete from pagos_detalle where cod_pago=".$_POST['cod_pago']." and cod_tipo_doc=2";
	mysql_query($sql);
///////////////////////////////////////////////
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, g.gestion ,ot.cod_gestion, ot.numero_orden_trabajo, ";
	$sql.=" ot.fecha_orden_trabajo, ot.monto_orden_trabajo ";
	$sql.=" from ordentrabajo ot, gestiones g ";
	$sql.=" where ot.cod_est_ot<>2  ";
	$sql.=" and ot.cod_estado_pago_doc<>3 ";
	$sql.=" and ot.cod_gestion=g.cod_gestion "; 
	$sql.=" and ot.cod_cliente=".$cod_cliente;
	$sql.=" order by ot.fecha_orden_trabajo desc, ot.nro_orden_trabajo desc ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_orden_trabajo=$dat['cod_orden_trabajo'];
		 $nro_orden_trabajo=$dat['nro_orden_trabajo'];
		 $gestion=$dat['gestion'];
		 $cod_gestion=$dat['cod_gestion'];
		 $numero_orden_trabajo=$dat['numero_orden_trabajo'];
		 $fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
		 $monto_orden_trabajo=$dat['monto_orden_trabajo'];
		 
		 if($_POST['cod_orden_trabajo'.$cod_orden_trabajo]){
			 
			 $saldo_ordentrabajo=$_POST['saldo_ordentrabajo'.$cod_orden_trabajo];
			 $monto_pago_detalle=$_POST['monto_pago_ot'.$cod_orden_trabajo];		 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_orden_trabajo."',";
			 $sql2.=" cod_tipo_doc=2,";			 			 
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."'";

			 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE ORDENES DE TRABAJO////////////
			 
					$monto_pago_detalle_bs=0;

						$monto_pago_detalle_bs=$monto_pago_detalle;

					
					$saldo_actual=$saldo_ordentrabajo-$monto_pago_detalle_bs;
					if($saldo_actual<=0){
						$sql4=" update ordentrabajo set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;
						mysql_query($sql4);
					}else{
						$sql4=" update ordentrabajo set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;		
						mysql_query($sql4);				
					}
					
			///////////////////// FIN ACTUALIZAR ESTADO DE PAGO DE ORDENES DE TRABAJO////////////

		 }
		 
	}

///////////////////////////////////////////////////////////////////////////////////////

	///////////////////////ACTUALIZACION DE ESTADOS  DE SALIDAS POR VENTA ///////////////////////
	$sql=" select codigo_doc ";
	$sql.=" from pagos_detalle ";
	$sql.=" where cod_pago=".$_POST['cod_pago'];
	$sql.=" and cod_tipo_doc=3";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		 $cod_salida=$dat['codigo_doc'];
	
	 		$monto_venta=0;
			 		$sql2=" select sum(sd.precio_venta) ";
					$sql2.=" from salidas_detalle sd ";
					$sql2.=" where sd.cod_salida=".$cod_salida;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_venta=$dat2[0];
					}

	$sql2=" select  pd.monto_pago_detalle ";
	$sql2.=" from pagos_detalle pd, pagos p";
	$sql2.=" where pd.cod_pago=p.cod_pago";
	$sql2.=" and p.cod_estado_pago<>2";
	$sql2.=" and pd.codigo_doc=".$cod_salida;
	$sql2.=" and cod_tipo_doc=3";
	$sql2.=" and pd.cod_pago<>".$_POST['cod_pago'];

	$resp2 = mysql_query($sql2);
	$acuenta_venta=0;
	while($dat2=mysql_fetch_array($resp2)){
					
					$monto_pago_detalle=$dat2['monto_pago_detalle'];					
					$acuenta_venta=$acuenta_venta+$monto_pago_detalle;					
		}				

		if($acuenta_venta==0){
				$sql4=" update salidas set ";
				$sql4.=" cod_estado_pago_doc=1";
				$sql4.=" where cod_salida=".$cod_salida;	
				
				mysql_query($sql4);
		 }else{
		 	 if(($monto_venta-$acuenta_venta)>0){
					$sql4=" update salidas set ";
					$sql4.=" cod_estado_pago_doc=2";
					$sql4.=" where cod_salida=".$cod_salida;	
					mysql_query($sql4);
			 }
			 if(($monto_venta-$acuenta_venta)==0){
					$sql4=" update salidas set ";
					$sql4.=" cod_estado_pago_doc=3";
					$sql4.=" where cod_salida=".$cod_salida;	
					mysql_query($sql4);
			 }
		 }

		///////////////////////FIN ACTUALIZACION DE ESTADOS DE SALIDAS POR VENTA ///////////////////////
	}

	$sql="delete from pagos_detalle where cod_pago=".$_POST['cod_pago']." and cod_tipo_doc=3";
	mysql_query($sql);
////////////////////////////////DETALLE SALIDAS POR VENTA///////////////////////////////////
	$sql=" select s.cod_salida, s.nro_salida, s.cod_gestion, g.gestion, s.cliente_venta, s.fecha_salida ";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_gestion=g.cod_gestion ";
	$sql.=" and s.cod_tipo_salida=1 ";
	$sql.=" and s.cod_estado_salida=1 ";
	$sql.=" and s.cod_estado_pago_doc<>3 ";
	$sql.=" and s.cod_cliente_venta=".$cod_cliente;
	$sql.=" order by fecha_salida asc,s.nro_salida asc ";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
		  $cod_salida=$dat['cod_salida'];
		  $nro_salida=$dat['nro_salida'];
		  $cod_gestion=$dat['cod_gestion'];
		  $gestionVenta=$dat['gestion'];
		  $cliente_venta=$dat['cliente_venta'];
		  $fecha_salida=$dat['fecha_salida'];
		

		 
		 if($_POST['cod_salida'.$cod_salida]){
			 
			 $saldo_venta=$_POST['saldo_venta'.$cod_salida];
			 $monto_pago_detalle=$_POST['monto_pago_venta'.$cod_salida];			 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_salida."',";
			 $sql2.=" cod_tipo_doc=3,";			 			
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."'";
	 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE SALIDA////////////
			 
					$monto_pago_detalle_bs=0;
					$monto_pago_detalle_bs=$monto_pago_detalle;

					
					$saldo_actual=$saldo_venta-$monto_pago_detalle_bs;
					if($saldo_actual<=0){
						$sql4=" update salidas set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_salida=".$cod_salida;
						mysql_query($sql4);
					}else{
						$sql4=" update salidas set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_salida=".$cod_salida;		
						mysql_query($sql4);				
					}
					
			///////////////////// FIN ACTUALIZAR ESTADO DE PAGO DE SALIDAS POR VENTA////////////

		 }
		 
	}

////////////////////////////////FIN DETALLE SALIDAS POR VENTA///////////////////////////////////
	$sql="delete from pagos_descripcion where cod_pago=".$_POST['cod_pago']." ";
	mysql_query($sql);

$sql3="select cambio_bs from tipo_cambio";
$sql3.=" where fecha_tipo_cambio='".date('Y-m-d', time())."'";
$sql3.=" and cod_moneda=2";
$resp3 = mysql_query($sql3);
$cambio_bs=0;
while($dat3=mysql_fetch_array($resp3)){
	$cambio_bs=$dat3['cambio_bs'];
}
							
$sql=" select cod_forma_pago from forma_pago";
$resp= mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	$cod_forma_pago=$dat['cod_forma_pago'];	
	$montoPagoBs=0;	
	if($_POST['montoPagoBs'.$cod_forma_pago]){
		$montoPagoBs=$_POST['montoPagoBs'.$cod_forma_pago];
	}
	$bancoBs=NULL;
	if($_POST['bancoBs'.$cod_forma_pago]){
		$bancoBs=$_POST['bancoBs'.$cod_forma_pago];
	}
	$nro_chequeBs="";
	if($_POST['nro_chequeBs'.$cod_forma_pago]){
		$nro_chequeBs=$_POST['nro_chequeBs'.$cod_forma_pago];
	}
	$nro_cuentaBs="";	
	if($_POST['nro_cuentaBs'.$cod_forma_pago]){
		$nro_cuentaBs=$_POST['nro_cuentaBs'.$cod_forma_pago];
	}	
	if($montoPagoBs>0){
		$sql2="	insert into pagos_descripcion set ";
		$sql2.=" cod_pago=".$cod_pago. ",";
		$sql2.=" cod_forma_pago=".$cod_forma_pago. ",";
		$sql2.=" cod_moneda=1,"; 
		$sql2.=" monto_pago=".$montoPagoBs.","; 
		if($cod_forma_pago==2 or $cod_forma_pago==3){
			$sql2.=" cod_banco=".$bancoBs. ",";
		}
		$sql2.=" nro_cheque='".$nro_chequeBs."',";
		$sql2.=" nro_cuenta='".$nro_cuentaBs."'";
		//echo $sql2;
		 mysql_query($sql2);
	
	}	
	
	$montoPagoSus=0;	
	if($_POST['montoPagoSus'.$cod_forma_pago]){
		$montoPagoSus=$_POST['montoPagoSus'.$cod_forma_pago];
	}
	$bancoSus=NULL;
	if($_POST['bancoSus'.$cod_forma_pago]){
		$bancoSus=$_POST['bancoSus'.$cod_forma_pago];
	}
	$nro_chequeSus="";
	if($_POST['nro_chequeSus'.$cod_forma_pago]){
		$nro_chequeSus=$_POST['nro_chequeSus'.$cod_forma_pago];
	}
	$nro_cuentaSus="";	
	if($_POST['nro_cuentaSus'.$cod_forma_pago]){
		$nro_cuentaSus=$_POST['nro_cuentaSus'.$cod_forma_pago];
	}	
	if($montoPagoSus>0){
		$sql2="	insert into pagos_descripcion set ";
		$sql2.=" cod_pago=".$cod_pago. ",";
		$sql2.=" cod_forma_pago=".$cod_forma_pago. ",";
		$sql2.=" cod_moneda=2,"; 
		$sql2.=" monto_pago=".$montoPagoSus.","; 
		if($cod_forma_pago==2 or $cod_forma_pago==3){
			$sql2.=" cod_banco=".$bancoSus. ",";
		}
		$sql2.=" nro_cheque='".$nro_chequeSus."',";
		$sql2.=" nro_cuenta='".$nro_cuentaSus."'";
		//echo $sql2;
		mysql_query($sql2);	
	}		
	
}

/// CREACION DE COMPROBANTE/////

	$sql="select cod_cuenta from clientes where cod_cliente=".$cod_cliente;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_cuenta_haber=$dat['cod_cuenta'];
	}
	$sql="select cod_cbte from pagos where cod_pago=".$_POST['cod_pago'];
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_cbte=$dat['cod_cbte'];
	}	


	
	
	$sql=" select cod_tipo_doc,codigo_doc, monto_pago_detalle ";
	$sql.=" from pagos_detalle ";
	$sql.=" where cod_pago=".$_POST['cod_pago'];
	$sql.=" order by cod_tipo_doc,codigo_doc";
	$resp= mysql_query($sql);
	$glosa="";
	while($dat=mysql_fetch_array($resp)){
		$cod_tipo_doc=$dat['cod_tipo_doc'];
		$codigo_doc=$dat['codigo_doc'];
		$monto_pago_detalle=$dat['monto_pago_detalle']; 
		$sql2="select abrev_tipo_doc from tipo_documento where cod_tipo_doc=".$cod_tipo_doc;
		$resp2= mysql_query($sql2);
		$abrev_tipo_doc="";
		while($dat2=mysql_fetch_array($resp2)){
			$abrev_tipo_doc=$dat2['abrev_tipo_doc'];
		}
		$nro_documento="";
		if($cod_tipo_doc==1){	
				$sql2=" select hr.nro_hoja_ruta,g.gestion from hojas_rutas hr, gestiones g ";
				$sql2.=" where hr.cod_gestion=g.cod_gestion and hr.cod_hoja_ruta=".$codigo_doc;
				$resp2= mysql_query($sql2);
				$nro_documento="";
				while($dat2=mysql_fetch_array($resp2)){
					$nro_documento=$dat2['nro_hoja_ruta']."/".$dat2['gestion'];
				}	
		}
		if($cod_tipo_doc==2){
				$sql2=" select ot.nro_orden_trabajo,g.gestion from ordentrabajo ot, gestiones g ";
				$sql2.=" where ot.cod_gestion=g.cod_gestion and ot.cod_orden_trabajo=".$codigo_doc;
				$resp2= mysql_query($sql2);
				$nro_documento="";
				while($dat2=mysql_fetch_array($resp2)){
					$nro_documento=$dat2['nro_orden_trabajo']."/".$dat2['gestion'];
				}	
		}
		if($cod_tipo_doc==3){
				$sql2=" select sal.nro_salida,g.gestion from salidas sal, gestiones g ";
				$sql2.=" where sal.cod_gestion=g.cod_gestion and sal.cod_salida=".$codigo_doc;
				//echo $sql2;
				$resp2= mysql_query($sql2);
				$nro_documento="";
				while($dat2=mysql_fetch_array($resp2)){
					$nro_documento=$dat2['nro_salida']."/".$dat2['gestion'];
				}	
		}	
		$glosa=$glosa."Pago de ".$abrev_tipo_doc." ".$nro_documento." ".$monto_pago_detalle." Bs ;";	
				
	}
	//echo "glosa=".$glosa;
	$sql=" update comprobante  set ";	
	$sql.=" cod_empresa=1,";
	$sql.=" cod_gestion=".$cod_gestion.",";
	$sql.=" cod_tipo_cbte=3,";
	$sql.=" cod_moneda=1,";
	$sql.=" cod_estado_cbte=1,";
	$sql.=" fecha_cbte='".date('Y-m-d', time())."',";
	$sql.=" glosa='".$glosa."',";
	$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
	$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
	$sql.="where  cod_cbte=".$cod_cbte."";
	mysql_query($sql);
	
	$sql="delete from comprobante_detalle where cod_cbte='".$cod_cbte."'";
	mysql_query($sql);

	
	$sql="select cod_cuenta from clientes where cod_cliente=".$cod_cliente;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_cuenta_haber=$dat['cod_cuenta'];
				
	}	
	$sql="select cod_moneda  from monedas";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_moneda=$dat['cod_moneda'];
		$sql2="select count(*) from pagos_descripcion where cod_pago=".$cod_pago." and cod_moneda=".$cod_moneda;
		$resp2= mysql_query($sql2);
		$nroPagoMoneda=0;
		while($dat2=mysql_fetch_array($resp2)){
			$nroPagoMoneda=$dat2[0];
		}
		if($nroPagoMoneda>0){
			$sql2="select sum(monto_pago)  from pagos_descripcion where cod_pago=".$cod_pago." and cod_moneda=".$cod_moneda;
			$resp2= mysql_query($sql2);
			$montoTotalPagoMoneda=0;
			while($dat2=mysql_fetch_array($resp2)){
				$montoTotalPagoMoneda=$dat2[0];
			}
			
			$sql2="select cod_cuenta from configuracion_tipo_cbte where cod_moneda=".$cod_moneda." and cod_tipo_cbte=3";
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$cod_cuenta_debe=$dat2['cod_cuenta'];
			}
			$montoTotalPagoMonedaSus=0;
			if($cod_moneda==1){
				$montoTotalPagoMoneda=$montoTotalPagoMoneda;
				$montoTotalPagoMonedaSus=$montoTotalPagoMoneda/$cambio_bs;
			}
			if($cod_moneda==2){
				$montoTotalPagoMonedaSus=$montoTotalPagoMoneda;
				$montoTotalPagoMoneda=$montoTotalPagoMoneda*$cambio_bs;
				
				
			}
			//echo "moneda bs=".$montoTotalPagoMoneda;
			//echo "moneda sus=".$montoTotalPagoMonedaSus;
			$sql="select max(cod_cbte_detalle) from comprobante_detalle where cod_cbte='".$cod_cbte."'";
			$cod_cbte_detalle=obtenerCodigo($sql);			
			$sql3=" insert into comprobante_detalle set ";
			$sql3.=" cod_cbte=".$cod_cbte.",";
			$sql3.=" cod_cbte_detalle=".$cod_cbte_detalle.",";
			$sql3.=" cod_cuenta=".$cod_cuenta_debe.",";
			$sql3.=" debe=".$montoTotalPagoMoneda.",";
			$sql3.=" haber=0,";
			$sql3.=" haber_sus=".$montoTotalPagoMonedaSus.",";
			$sql3.=" debe_sus=0,";					 
			$sql3.=" glosa='".$glosa."'";
		//	echo $sql3."<br/>";
			mysql_query($sql3);
			$sql="select max(cod_cbte_detalle) from comprobante_detalle where cod_cbte='".$cod_cbte."'";
			$cod_cbte_detalle=obtenerCodigo($sql);
			$sql3=" insert into comprobante_detalle set ";
			$sql3.=" cod_cbte=".$cod_cbte.",";
			$sql3.=" cod_cbte_detalle=".$cod_cbte_detalle.",";
			$sql3.=" cod_cuenta=".$cod_cuenta_haber.","; 
			$sql3.=" debe=0,";
			$sql3.=" haber=".$montoTotalPagoMoneda.",";	
			$sql3.=" haber_sus=0,";
			$sql3.=" debe_sus=".$montoTotalPagoMonedaSus.",";					 
			$sql3.=" glosa='".$glosa."'";
		//				echo $sql3."<br/>";
			mysql_query($sql3);
			
		}

	}
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="viewPago.php?cod_pago=<?php echo $cod_pago;?>";
</script>