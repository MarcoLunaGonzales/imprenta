<?php 
	require("conexion.inc");
	include("funciones.php");
	//set_time_limit(120);
	/////////////////////////////
function saldoAnteriorClienteHR($cliente,$fecha){
	 $montoClienteF=0;
	 $aCuentaClienteF=0;
	 $saldoClienteF=0;	
 	 $sql=" select hr.cod_hoja_ruta, hr.cod_gestion, g.gestion, hr.nro_hoja_ruta, hr.fecha_hoja_ruta, ";
	 $sql.=" hr.cod_usuario_hoja_ruta, hr.obs_hoja_ruta, hr.cod_cotizacion,c.cod_cliente, cli.nombre_cliente, ";
	 $sql.=" hr.cod_estado_hoja_ruta, hr.factura_si_no, hr.cod_usuario_comision, hr.fecha_registro, ";
	 $sql.=" hr.cod_usuario_registro, hr.fecha_modifica, hr.cod_usuario_modifica, hr.cod_tipo_pago, hr.cod_estado_pago_doc ";
	 $sql.=" from hojas_rutas hr, cotizaciones c, gestiones g, clientes cli ";
	 $sql.=" where hr.cod_cotizacion=c.cod_cotizacion ";
	 $sql.=" and c.cod_cliente=cli.cod_cliente ";
	 $sql.=" and hr.cod_gestion=g.cod_gestion ";
	 $sql.=" and hr.cod_estado_hoja_ruta<>2 ";
	 $sql.=" and hr.cod_estado_pago_doc<>3 ";			
	 $sql.=" and hr.fecha_hoja_ruta<'".$fecha."' ";
	 $sql.=" and c.cod_cliente=".$cliente;
	/////////////////////FILTRO POR TIPO DE PAGO//////////
	$sqlAux3=" select cod_tipo_pago from tipos_pago ";
	$respAux3=mysql_query($sqlAux3);
	$swAux=0;
	while($datAux3=mysql_fetch_array($respAux3))
	{
			$cod_tipo_pago=$datAux3[0];	

			if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
				if($swAux==0){
					$sql.=" and ( hr.cod_tipo_pago=".$cod_tipo_pago."";
					$swAux=1;
				}else{				
					$sql.=" or hr.cod_tipo_pago=".$cod_tipo_pago."";	
				}

			}

	}	
	if($swAux==1){
		$sql.=" )";
	}
	/////////////////////FILTRO POR TIPO DE PAGO//////////	 
	 $sql.=" order by hr.fecha_hoja_ruta  asc ";	

	 $resp=mysql_query($sql);
	 while($dat=mysql_fetch_array($resp))
	 {	
				$cod_hoja_ruta=$dat['cod_hoja_ruta'];
				$cod_gestion=$dat['cod_gestion']; 
				$gestionHojaRuta=$dat['gestion'];
				$nro_hoja_ruta=$dat['nro_hoja_ruta']; 
				$fecha_hoja_ruta=$dat['fecha_hoja_ruta']; 
				$cod_usuario_hoja_ruta=$dat['cod_usuario_hoja_ruta']; 
				$obs_hoja_ruta=$dat['obs_hoja_ruta']; 
				$cod_cotizacion=$dat['cod_cotizacion']; 
				$cod_cliente=$dat['cod_cliente']; 
				$nombre_cliente=$dat['nombre_cliente']; 
				$cod_estado_hoja_ruta=$dat['cod_estado_hoja_ruta']; 
				$factura_si_no=$dat['factura_si_no']; 
				$cod_usuario_comision=$dat['cod_usuario_comision']; 
				$fecha_registro=$dat['fecha_registro']; 
				$cod_usuario_registro=$dat['cod_usuario_registro']; 
				$fecha_modifica=$dat['fecha_modifica']; 
				$cod_usuario_modifica=$dat['cod_usuario_modifica']; 
				$cod_tipo_pago=$dat['cod_tipo_pago']; 				
				$sqlCotizacion=" select c.nro_cotizacion, g.gestion ";
				$sqlCotizacion.=" from cotizaciones c, gestiones g";
				$sqlCotizacion.=" where c.cod_gestion=g.cod_gestion";
				$sqlCotizacion.=" and c.cod_cotizacion=".$cod_cotizacion;
				$resp2 = mysql_query($sqlCotizacion);
				while($dat2=mysql_fetch_array($resp2)){
					$nro_cotizacion=$dat2['nro_cotizacion'];
					$gestion_cotizacion=$dat2['gestion'];
				}		

				$cod_estado_pago_doc=$dat['cod_estado_pago_doc']; 
				////////////////////////////////
				$monto_hojaruta=0;				
				$sqlAux=" select sum(cd.IMPORTE_TOTAL) ";
				$sqlAux.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
				$sqlAux.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
				$sqlAux.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
				$sqlAux.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
				$respAux = mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
							$monto_hojaruta=$datAux[0];
				}	
				////Descuento Cotizacion////////
					 $descuento_cotizacion=0;
						$sqlAux="select descuento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
						$respAux = mysql_query($sqlAux);
						while($datAux=mysql_fetch_array($respAux)){
							$descuento_cotizacion=$datAux[0];
						}
					
				/////Fin descuento Cotizacion////////
				////Incremento Cotizacion////////
					 $incremento_cotizacion=0;
						$sqlAux="select incremento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
						$respAux = mysql_query($sqlAux);
						while($datAux=mysql_fetch_array($respAux)){
							$incremento_cotizacion=$datAux[0];
						}
					
				/////Fin Incremento Cotizacion////////
					 					 
				/////////A cuenta///////
					 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
					 	$sql2.=" from pagos_detalle pd, pagos p";
				 		$sql2.=" where pd.cod_pago=p.cod_pago";
					 	$sql2.=" and p.cod_estado_pago<>2";
					 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
						$sql2.=" and pd.cod_tipo_doc=1";
						$resp2 = mysql_query($sql2);
						$acuenta_hojaruta=0;
						while($dat2=mysql_fetch_array($resp2)){
							$cod_moneda=$dat2['cod_moneda'];
							$monto_pago_detalle=$dat2['monto_pago_detalle'];
							$fecha_pago=$dat2['fecha_pago'];

							if($cod_moneda==1){
								$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
							}else{
									$sql3=" select cambio_bs from tipo_cambio";
									$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
									$sql3.=" and cod_moneda=".$cod_moneda;
									$resp3=mysql_query($sql3);
									$cambio_bs=0;
									while($dat3=mysql_fetch_array($resp3)){
										$cambio_bs=$dat3['cambio_bs'];
									}
									if($cambio_bs<>0){
										$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);							
									}
							}
						}						 
				///////Fin a cuenta////////////	
						
				$montoClienteF=$montoClienteF+(($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion);
				$aCuentaClienteF=$aCuentaClienteF+$acuenta_hojaruta;
				//$saldoClienteF=$saldoClienteF+((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion)-$acuenta_hojaruta);
										 
	
	 }

	return($montoClienteF-$aCuentaClienteF);
}	
	//////////////////////////////
	///////////////////////
function saldoAnteriorClienteOT($cliente,$fecha){
	 $montoClienteOTF=0;
	 $aCuentaClienteOTF=0;
	 $saldoClienteOTF=0;	
 	 $sql=" select ot.cod_orden_trabajo, ot.cod_gestion, g.gestion, ot.nro_orden_trabajo,ot.fecha_orden_trabajo, ";
	 $sql.=" ot.cod_est_ot,  ot.cod_estado_pago_doc, ot.monto_orden_trabajo, ot.incremento_orden_trabajo, ";
	 $sql.=" ot.descuento_orden_trabajo ";
	 $sql.=" from ordentrabajo ot,  gestiones g ";
	 $sql.=" where ot.cod_gestion=g.cod_gestion ";
	 $sql.=" and ot.cod_est_ot<>2 ";
	 $sql.=" and ot.cod_estado_pago_doc<>3 ";			
	 $sql.=" and ot.fecha_orden_trabajo<'".$fecha."' ";
	 $sql.=" and ot.cod_cliente=".$cliente;
	/////////////////////FILTRO POR TIPO DE PAGO//////////
	$sqlAux3=" select cod_tipo_pago from tipos_pago ";
	$respAux3=mysql_query($sqlAux3);
	$swAux=0;
	while($datAux3=mysql_fetch_array($respAux3))
	{
			$cod_tipo_pago=$datAux3[0];	

			if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
				if($swAux==0){
					$sql.=" and ( ot.cod_tipo_pago=".$cod_tipo_pago."";
					$swAux=1;
				}else{				
					$sql.=" or ot.cod_tipo_pago=".$cod_tipo_pago."";	
				}

			}

	}	
	if($swAux==1){
		$sql.=" )";
	}
	/////////////////////FILTRO POR TIPO DE PAGO//////////	 
	 $sql.=" order by ot.fecha_orden_trabajo  asc ";


	 $resp=mysql_query($sql);
	 while($dat=mysql_fetch_array($resp))
	 {	
				$cod_orden_trabajo=$dat['cod_orden_trabajo'];
				$cod_gestion=$dat['cod_gestion'];
				$gestion=$dat['gestion'];
				$nro_orden_trabajo=$dat['nro_orden_trabajo'];
				$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
	  			$cod_est_ot=$dat['cod_est_ot'];
				$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
				$monto_orden_trabajo=$dat['monto_orden_trabajo'];
				$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
				$descuento_orden_trabajo=$dat['descuento_orden_trabajo'];

					 					 
				/////////A cuenta///////
					 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
					 	$sql2.=" from pagos_detalle pd, pagos p";
				 		$sql2.=" where pd.cod_pago=p.cod_pago";
					 	$sql2.=" and p.cod_estado_pago<>2";
					 	$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
						$sql2.=" and pd.cod_tipo_doc=2";
						$resp2 = mysql_query($sql2);
						$acuenta_ordentrabajo=0;
						while($dat2=mysql_fetch_array($resp2)){
							$cod_moneda=$dat2['cod_moneda'];
							$monto_pago_detalle=$dat2['monto_pago_detalle'];
							$fecha_pago=$dat2['fecha_pago'];

							if($cod_moneda==1){
								$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
							}else{
									$sql3=" select cambio_bs from tipo_cambio";
									$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
									$sql3.=" and cod_moneda=".$cod_moneda;
									$resp3=mysql_query($sql3);
									$cambio_bs=0;
									while($dat3=mysql_fetch_array($resp3)){
										$cambio_bs=$dat3['cambio_bs'];
									}
									if($cambio_bs<>0){
										$acuenta_ordentrabajo=$acuenta_ordentrabajo+($monto_pago_detalle*$cambio_bs);							
									}
							}
						}						 
				///////Fin a cuenta////////////	
						
				$montoClienteOTF=$montoClienteOTF+(($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo);
				$aCuentaClienteOTF=$aCuentaClienteOTF+$acuenta_ordentrabajo;
										 
	
	 }

	return($montoClienteOTF-$aCuentaClienteOTF);
}	

function saldoAnteriorClienteVenta($cliente,$fecha){
	 $montoClienteF=0;
	 $aCuentaClienteF=0;
	 $saldoClienteF=0;	
    $sql=" select s.cod_salida, s.nro_salida, s.cod_gestion, g.gestion, s.cliente_venta, s.fecha_salida ";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_gestion=g.cod_gestion ";
	$sql.=" and s.cod_tipo_salida=1 ";
	$sql.=" and s.cod_estado_salida=1 ";
	$sql.=" and s.cod_estado_pago_doc<>3 ";
	$sql.=" and s.cod_cliente_venta=".$cliente;
	$sql.=" and s.fecha_salida<'".$fecha."' ";	
	$sqlAux3=" select cod_tipo_pago from tipos_pago ";
	$respAux3=mysql_query($sqlAux3);
	$swAux=0;
	while($datAux3=mysql_fetch_array($respAux3))
	{
			$cod_tipo_pago=$datAux3[0];	

			if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
				if($swAux==0){
					$sql.=" and ( s.cod_tipo_pago=".$cod_tipo_pago."";
					$swAux=1;
				}else{				
					$sql.=" or s.cod_tipo_pago=".$cod_tipo_pago."";	
				}

			}

	}	
	if($swAux==1){
		$sql.=" )";
	}
	/////////////////////FILTRO POR TIPO DE PAGO//////////	 	
	$sql.=" order by s.fecha_salida asc,s.nro_salida asc ";

	$resp= mysql_query($sql);
	$gestionVenta="";
	while($dat=mysql_fetch_array($resp)){
		
		  $cod_salida=$dat['cod_salida'];
		  $nro_salida=$dat['nro_salida'];
		  $cod_gestion=$dat['cod_gestion'];
		  $gestionVenta=$dat['gestion'];
		  $cliente_venta=$dat['cliente_venta'];
		  $fecha_salida=$dat['fecha_salida'];
		

	 		$monto_venta=0;
			 		$sql2=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sql2.=" from salidas_detalle sd ";
					$sql2.=" where sd.cod_salida=".$cod_salida;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_venta=$dat2[0];
					}

					 					 
				/////////A cuenta///////
					 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
					 	$sql2.=" from pagos_detalle pd, pagos p";
				 		$sql2.=" where pd.cod_pago=p.cod_pago";
					 	$sql2.=" and p.cod_estado_pago<>2";
					 	$sql2.=" and pd.codigo_doc=".$cod_salida;
						$sql2.=" and pd.cod_tipo_doc=3";
						$resp2 = mysql_query($sql2);
						$acuenta_venta=0;
						while($dat2=mysql_fetch_array($resp2)){
							$cod_moneda=$dat2['cod_moneda'];
							$monto_pago_detalle=$dat2['monto_pago_detalle'];
							$fecha_pago=$dat2['fecha_pago'];

							if($cod_moneda==1){
								$acuenta_venta=$acuenta_venta+$monto_pago_detalle;
							}else{
									$sql3=" select cambio_bs from tipo_cambio";
									$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
									$sql3.=" and cod_moneda=".$cod_moneda;
									$resp3=mysql_query($sql3);
									$cambio_bs=0;
									while($dat3=mysql_fetch_array($resp3)){
										$cambio_bs=$dat3['cambio_bs'];
									}
									if($cambio_bs<>0){
										$acuenta_venta=$acuenta_venta+($monto_pago_detalle*$cambio_bs);							
									}
							}
						}						 
				///////Fin a cuenta////////////	
						
				$montoClienteF=$montoClienteF+$monto_venta;
				$aCuentaClienteF=$aCuentaClienteF+$acuenta_venta;
			
	 }

	return($montoClienteF-$aCuentaClienteF);
}		
	////////////////////////
	
	
	$codcliente=$_POST['cod_cliente'];
	if($codcliente<>0){
		$sql="select nombre_cliente from clientes where cod_cliente=".$codcliente;
		$resp = mysql_query($sql);
		while($dat_aux=mysql_fetch_array($resp)){
			$nombrecliente=$dat_aux[0];
		}
	}
	$fecha_inicio=$_POST['fecha_inicio'];
	list($dI,$mI,$aI)=explode("/",$fecha_inicio);	
	
	$fecha_final=$_POST['fecha_final'];
	list($dF,$mF,$aF)=explode("/",$fecha_final);	
	
     $fechaInicial=$aI."-".$mI."-".$dI;
	 $dias=1;	 
	 $fechaSaldoInicialInventa=date("Y-m-d", strtotime("$fechaInicial -$dias day"));
	 list($aaaa,$mm,$dd)=explode("-",$fechaSaldoInicialInventa);
	 $cod_tipo_doc=$_POST['cod_tipo_doc'];
	 
	 if($codtipodoc<>0){
		$sql="select desc_tipo_doc from tipo_documento where cod_tipo_doc=".$codtipodoc;
		$resp = mysql_query($sql);
		while($dat_aux=mysql_fetch_array($resp)){
			$desc_tipo_doc=$dat_aux[0];
		}
	}else{
		$desc_tipo_doc="TODOS LOS DOCUMENTOS";	
	}



				

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script type="text/javascript" src="ajax/searchAjax.js"></script>
<script type="text/javascript">
function imprimirPagina() {
  if (window.print)
    window.print();
  else
    alert("Lo sentimos existe un error, consultar con el administrador.");
}

</script>
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">ESTADO DE CUENTAS POR COBRAR</h3>
<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">DE: <?php echo $dI."/".$mI."/".$aI;?> &nbsp;&nbsp; HASTA: <?php echo $dF."/".$mF."/".$aF;?></h3>
<?php if($codcliente<>0){ ?>
<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">CLIENTE: <?php echo $nombrecliente; ?></h3>

<?php } ?>
<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">TIPO DE DOCUMENTO: <?php echo strtoupper($desc_tipo_doc); ?></h3>

<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">TIPO PAGO:
<?php
	$sqlAux3=" select cod_tipo_pago, nombre_tipo_pago from tipos_pago ";
	$respAux3=mysql_query($sqlAux3);
	$swAux=0;
	while($datAux3=mysql_fetch_array($respAux3)){
			$cod_tipo_pago=$datAux3[0];	
			$nombre_tipo_pago=$datAux3[1];	

			if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
				echo  $nombre_tipo_pago."; ";
			}

	}	
 ?>
 </h3>
<form name="form1" method="post" >

<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
<tr class="texto">  </tr>
</table>
<br/>

<?php 

		$sql2=" select cod_cliente,nombre_cliente";
		$sql2.=" from clientes ";
		$sql2.=" where (cod_cliente in(select DISTINCT(c.cod_cliente)from hojas_rutas hr, cotizaciones c ";
		$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion and hr.cod_estado_hoja_ruta<>2 and hr.cod_estado_pago_doc<>3)";
		$sql2.=" or  cod_cliente in(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2 and ";
		$sql2.=" cod_estado_pago_doc<>3)";
		$sql2.=" or  cod_cliente in(select DISTINCT(cod_cliente_venta) from salidas where cod_tipo_salida=1";
		$sql2.=" and cod_estado_salida=1 and cod_estado_pago_doc<>3))";											
		if($codcliente<>0){
			$sql2.=" and cod_cliente=".$codcliente;
		}		
		$sql2.=" order by nombre_cliente";
			$nro_filas_sql_hr=0;
			$nro_filas_sql_ot=0;	
			$nro_filas_sql_venta=0;		
			$nro_filas_sql=0;
		$resp2=mysql_query($sql2);
		while($dat2=mysql_fetch_array($resp2)){
			$cod_cliente=$dat2['cod_cliente'];	
			$nombre_cliente=$dat2['nombre_cliente'];		
			
			if($codtipodoc==1 or $codtipodoc==0){	
			////////////////////HOJAS RUTAS//////////////////////////
			$sql=" select count(*)";
			$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
			$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
			$sql.=" and hr.cod_gestion=g.cod_gestion";
			$sql.=" and hr.cod_estado_hoja_ruta<>2";
			$sql.=" and hr.cod_estado_pago_doc<>3";
			$sql.=" and c.cod_cliente=".$cod_cliente;
			if($fecha_inicio<>"" and $fecha_final<>""){
					list($dI,$mI,$aI)=explode("/",$fecha_inicio);
					list($dF,$mF,$aF)=explode("/",$fecha_final);			
					$sql.=" and (hr.fecha_hoja_ruta>='".$aI."-".$mI."-".$dI."' and hr.fecha_hoja_ruta<='".$aF."-".$mF."-".$dF."') ";				
			}			

			/////////////////////FILTRO POR TIPO DE PAGO//////////
			$sqlAux3=" select cod_tipo_pago from tipos_pago ";
			$respAux3=mysql_query($sqlAux3);
			$swAux=0;
			while($datAux3=mysql_fetch_array($respAux3)){
				$cod_tipo_pago=$datAux3[0];	
	
				if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
					if($swAux==0){
						$sql.=" and ( hr.cod_tipo_pago=".$cod_tipo_pago."";
						$swAux=1;
					}else{				
						$sql.=" or hr.cod_tipo_pago=".$cod_tipo_pago."";	
					}
		 	    }

			}	
			if($swAux==1){
				$sql.=" )";
			}	
			$resp = mysql_query($sql);
			while($dat_aux=mysql_fetch_array($resp)){
				$nro_filas_sql_hr=$nro_filas_sql_hr+$dat_aux[0];

				
			}
			

			////////////////////FIN HOJAS RUTAS//////////////////////////
			
			}
			if($codtipodoc==2 or $codtipodoc==0){
			////////////////////ORDENES DE TRABAJO//////////////////////////
			$sql=" select count(*)";
			$sql.=" from ordentrabajo ot, gestiones g";
			$sql.=" where ot.cod_gestion=g.cod_gestion";
			$sql.=" and ot.cod_est_ot<>2";
			$sql.=" and ot.cod_estado_pago_doc<>3";
			$sql.=" and ot.cod_cliente=".$cod_cliente;
			if($fecha_inicio<>"" and $fecha_final<>""){
				list($dI,$mI,$aI)=explode("/",$fecha_inicio);
				list($dF,$mF,$aF)=explode("/",$fecha_final);			
				$sql.=" and (ot.fecha_orden_trabajo>='".$aI."-".$mI."-".$dI."' and ot.fecha_orden_trabajo<='".$aF."-".$mF."-".$dF."') ";				
			}			

			/////////////////////FILTRO POR TIPO DE PAGO//////////
			$sqlAux3=" select cod_tipo_pago from tipos_pago ";
			$respAux3=mysql_query($sqlAux3);
			$swAux=0;
			while($datAux3=mysql_fetch_array($respAux3)){
				$cod_tipo_pago=$datAux3[0];	
	
				if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
					if($swAux==0){
						$sql.=" and ( ot.cod_tipo_pago=".$cod_tipo_pago."";
						$swAux=1;
					}else{				
						$sql.=" or ot.cod_tipo_pago=".$cod_tipo_pago."";	
					}
		 	    }

			}	
			if($swAux==1){
				$sql.=" )";
			}
				
			$resp = mysql_query($sql);
			while($dat_aux=mysql_fetch_array($resp)){
				$nro_filas_sql_ot=$nro_filas_sql_ot+$dat_aux[0];
			}

			}
			
			if($codtipodoc==3 or $codtipodoc==0){	
			////////////////////SALIDAS POR VENTA//////////////////////////
			$sql=" select count(*)";
			$sql.=" from salidas s, gestiones g";
			$sql.=" where  s.cod_gestion=g.cod_gestion";
			$sql.=" and s.cod_estado_salida<>2";
			$sql.=" and s.cod_estado_pago_doc<>3";
			$sql.=" and s.cod_cliente_venta=".$cod_cliente;
			if($fecha_inicio<>"" and $fecha_final<>""){
					list($dI,$mI,$aI)=explode("/",$fecha_inicio);
					list($dF,$mF,$aF)=explode("/",$fecha_final);			
					$sql.=" and (s.fecha_salida>='".$aI."-".$mI."-".$dI."' and s.fecha_salida<='".$aF."-".$mF."-".$dF."') ";				
			}			

			/////////////////////FILTRO POR TIPO DE PAGO//////////
			$sqlAux3=" select cod_tipo_pago from tipos_pago ";
			$respAux3=mysql_query($sqlAux3);
			$swAux=0;
			while($datAux3=mysql_fetch_array($respAux3)){
				$cod_tipo_pago=$datAux3[0];	
	
				if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
					if($swAux==0){
						$sql.=" and ( s.cod_tipo_pago=".$cod_tipo_pago."";
						$swAux=1;
					}else{				
						$sql.=" or s.cod_tipo_pago=".$cod_tipo_pago."";	
					}
		 	    }

			}	
			if($swAux==1){
				$sql.=" )";
			}	
			
			$resp = mysql_query($sql);

			while($dat_aux=mysql_fetch_array($resp)){
				$nro_filas_sql_venta=$nro_filas_sql_venta+$dat_aux[0];
				
			}


			////////////////////FIN SALIDAS POR VENTA//////////////////////////
			
			}			
}
 $nro_filas_sql=$nro_filas_sql_hr+$nro_filas_sql_ot+$nro_filas_sql_venta;

?>
	<div id="nroRows" align="center" class="textoform"><?php echo "Nro. de Registros: ".$nro_filas_sql; ?></div>
    <br/>
<?php

	if($nro_filas_sql==0){
		$saldoInicialInventa=0;
		$saldoInicialClienteHR=0;
		$saldoInicialClienteOT=0;
		$saldoInicialClienteVenta=0;
		$fecha_inicio=$_POST['fecha_inicio'];
	    list($dI,$mI,$aI)=explode("/",$fecha_inicio);		
		///////////////////////////////////////////////////////////
		$sql2=" select cod_cliente,nombre_cliente";
		$sql2.=" from clientes ";
		$sql2.=" where (cod_cliente in(select DISTINCT(c.cod_cliente)from hojas_rutas hr, cotizaciones c ";
		$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion and hr.cod_estado_hoja_ruta<>2 and hr.cod_estado_pago_doc<>3)";
		$sql2.=" or  cod_cliente in(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2 and ";
		$sql2.=" cod_estado_pago_doc<>3)";
		$sql2.=" or  cod_cliente in(select DISTINCT(cod_cliente_venta) from salidas where cod_tipo_salida=1";
		$sql2.=" and cod_estado_salida=1 and cod_estado_pago_doc<>3))";				
		if($codcliente<>0){
			$sql2.=" and cod_cliente=".$codcliente;
		}		
		$sql2.=" order by nombre_cliente";
		$resp2=mysql_query($sql2);
		while($dat2=mysql_fetch_array($resp2)){
			$cod_cliente=$dat2['cod_cliente'];	
			$nombre_cliente=$dat2['nombre_cliente'];		
			
			if($codtipodoc==1 or $codtipodoc==0){	
			
				$saldoInicialClienteHR=saldoAnteriorClienteHR($cod_cliente,$aI."-".$mI."-".$dI);
			}
			$saldoInicialInventa=$saldoInicialInventa+$saldoInicialClienteHR;	
			

			if($codtipodoc==2 or $codtipodoc==0){
	
				$saldoInicialClienteOT=saldoAnteriorClienteOT($cod_cliente,$aI."-".$mI."-".$dI);
			}
			$saldoInicialInventa=$saldoInicialInventa+$saldoInicialClienteOT;	


			if($codtipodoc==3 or $codtipodoc==0){	

				$saldoInicialClienteVenta=saldoAnteriorClienteVenta($cod_cliente,$aI."-".$mI."-".$dI);
			}
			$saldoInicialInventa=$saldoInicialInventa+$saldoInicialClienteVenta;	

		}
	
//////////////////////////////////////////////////////////////////	
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Tipo Doc.</td>
            <td>Doc</td>
			<td>Fecha Doc</td>
            <td>Fecha Entrega</td>	                                   
            <td>Pagos</td>
            <td>Monto Doc</td>
            <td>Descuento</td>
            <td>Incremento</td>
            <td>Total Doc</td>            
            <td>A cuenta</td>
            <td>Saldo</td>	 																																			            
		</tr>
		<tr><th colspan="11" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{

?>
<div align="center"><a href="javascript:imprimirPagina()">Imprimir</a></div>
<table width="95%" align="center" cellpadding="0" cellspacing="0" border="1" bgColor="#cccccc">

	    <tr height="20px" align="center"  class="titulo_tabla">         
			<td>Tipo Doc.</td>
            <td>Doc</td>
			<td>Fecha Doc</td>
            <td>Fecha Entrega</td>	                                   
            <td>Pagos</td>
            <td>Monto Doc</td>
            <td>Descuento</td>
            <td>Incremento</td>
            <td>Total Doc</td>            
            <td>A cuenta</td>
            <td>Saldo</td>	              	            																	
	  </tr>
<?php		

		$sql2=" select  cod_cliente,nombre_cliente, direccion_cliente, telefono_cliente, celular_cliente, fax_cliente ";
		$sql2.=" from clientes ";
		$sql2.=" where (cod_cliente in(select DISTINCT(c.cod_cliente)from hojas_rutas hr, cotizaciones c ";
		$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion and hr.cod_estado_hoja_ruta<>2 and hr.cod_estado_pago_doc<>3)";
		$sql2.=" or  cod_cliente in(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2 and ";
		$sql2.=" cod_estado_pago_doc<>3)";
		$sql2.=" or  cod_cliente in(select DISTINCT(cod_cliente_venta) from salidas where cod_tipo_salida=1";
		$sql2.=" and cod_estado_salida=1 and cod_estado_pago_doc<>3))";		
		if($codcliente<>0){
			$sql2.=" and cod_cliente=".$codcliente;
		}		
		$sql2.=" order by nombre_cliente";				
		$resp2=mysql_query($sql2);
		$saldoInicialInventa=0;
		$totalDeudaInventa=0;
		$aCuentaInventa=0;
		$saldoInventa=0;
		$cont=0;

		while($dat2=mysql_fetch_array($resp2)){
			
			$cod_cliente=$dat2['cod_cliente'];	
			$nombre_cliente=$dat2['nombre_cliente'];
			$direccion_cliente=$dat2['direccion_cliente'];
			$telefono_cliente=$dat2['telefono_cliente'];
			$celular_cliente=$dat2['celular_cliente'];
			$fax_cliente=$dat2['fax_cliente'];
			$saldoInicialClienteHR=0;
			$saldoInicialClienteOT=0;
			$saldoInicialClienteVenta=0;
			if($codtipodoc==1 or $codtipodoc==0){
				$saldoInicialClienteHR=saldoAnteriorClienteHR($cod_cliente,$aI."-".$mI."-".$dI);
			}
			if($codtipodoc==2 or $codtipodoc==0){
				$saldoInicialClienteOT=saldoAnteriorClienteOT($cod_cliente,$aI."-".$mI."-".$dI);
			}
			if($codtipodoc==3 or $codtipodoc==0){
				$saldoInicialClienteVenta=saldoAnteriorClienteVenta($cod_cliente,$aI."-".$mI."-".$dI);
			}			
			$saldoInicialInventa=$saldoInicialInventa+$saldoInicialClienteHR+$saldoInicialClienteOT+			$saldoInicialClienteVenta;

			
			
			$totalDeudaClienteHR=0;
			$acuentaClienteHR=0;
			$saldoClienteHR=0;
			$totalDeudaClienteOT=0;
			$acuentaClienteOT=0;
			$saldoClienteOT=0;	
			$totalDeudaClienteVenta=0;
			$acuentaClienteVenta=0;
			$saldoClienteVenta=0;	
			
			
			
			$nro_filas_sql_hr=0;
			$nro_filas_sql_ot=0;
			$nro_filas_sql_venta=0;
			////////////////////////////////////
			if($codtipodoc==1 or $codtipodoc==0){	
			////////////////////HOJAS RUTAS//////////////////////////
			$sql=" select count(*)";
			$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
			$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
			$sql.=" and hr.cod_gestion=g.cod_gestion";
			$sql.=" and hr.cod_estado_hoja_ruta<>2";
			$sql.=" and hr.cod_estado_pago_doc<>3";
			$sql.=" and c.cod_cliente=".$cod_cliente;
			if($fecha_inicio<>"" and $fecha_final<>""){
					list($dI,$mI,$aI)=explode("/",$fecha_inicio);
					list($dF,$mF,$aF)=explode("/",$fecha_final);			
					$sql.=" and (hr.fecha_hoja_ruta>='".$aI."-".$mI."-".$dI."' and hr.fecha_hoja_ruta<='".$aF."-".$mF."-".$dF."') ";				
			}			

			/////////////////////FILTRO POR TIPO DE PAGO//////////
			$sqlAux3=" select cod_tipo_pago from tipos_pago ";
			$respAux3=mysql_query($sqlAux3);
			$swAux=0;
			while($datAux3=mysql_fetch_array($respAux3)){
				$cod_tipo_pago=$datAux3[0];	
	
				if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
					if($swAux==0){
						$sql.=" and ( hr.cod_tipo_pago=".$cod_tipo_pago."";
						$swAux=1;
					}else{				
						$sql.=" or hr.cod_tipo_pago=".$cod_tipo_pago."";	
					}
		 	    }

			}	
			if($swAux==1){
				$sql.=" )";
			}	
			$resp = mysql_query($sql);
			$nro_filas_sql_hr=0;
			while($dat_aux=mysql_fetch_array($resp)){
				$nro_filas_sql_hr=$dat_aux[0];

				
			}
			

			////////////////////FIN HOJAS RUTAS//////////////////////////
			
			}
			if($codtipodoc==2 or $codtipodoc==0){
			////////////////////ORDENES DE TRABAJO//////////////////////////
			$sql=" select count(*)";
			$sql.=" from ordentrabajo ot, gestiones g";
			$sql.=" where ot.cod_gestion=g.cod_gestion";
			$sql.=" and ot.cod_est_ot<>2";
			$sql.=" and ot.cod_estado_pago_doc<>3";
			$sql.=" and ot.cod_cliente=".$cod_cliente;
			if($fecha_inicio<>"" and $fecha_final<>""){
				list($dI,$mI,$aI)=explode("/",$fecha_inicio);
				list($dF,$mF,$aF)=explode("/",$fecha_final);			
				$sql.=" and (ot.fecha_orden_trabajo>='".$aI."-".$mI."-".$dI."' and ot.fecha_orden_trabajo<='".$aF."-".$mF."-".$dF."') ";				
			}			

			/////////////////////FILTRO POR TIPO DE PAGO//////////
			$sqlAux3=" select cod_tipo_pago from tipos_pago ";
			$respAux3=mysql_query($sqlAux3);
			$swAux=0;
			while($datAux3=mysql_fetch_array($respAux3)){
				$cod_tipo_pago=$datAux3[0];	
	
				if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
					if($swAux==0){
						$sql.=" and ( ot.cod_tipo_pago=".$cod_tipo_pago."";
						$swAux=1;
					}else{				
						$sql.=" or ot.cod_tipo_pago=".$cod_tipo_pago."";	
					}
		 	    }

			}	
			if($swAux==1){
				$sql.=" )";
			}
				
			$resp = mysql_query($sql);
			$nro_filas_sql_ot=0;
			while($dat_aux=mysql_fetch_array($resp)){
				$nro_filas_sql_ot=$dat_aux[0];
			}

			}
			
			if($codtipodoc==3 or $codtipodoc==0){	
			////////////////////SALIDAS POR VENTA//////////////////////////
			$sql=" select count(*)";
			$sql.=" from salidas s, gestiones g";
			$sql.=" where  s.cod_gestion=g.cod_gestion";
			$sql.=" and s.cod_estado_salida<>2";
			$sql.=" and s.cod_estado_pago_doc<>3";
			$sql.=" and s.cod_cliente_venta=".$cod_cliente;
			if($fecha_inicio<>"" and $fecha_final<>""){
					list($dI,$mI,$aI)=explode("/",$fecha_inicio);
					list($dF,$mF,$aF)=explode("/",$fecha_final);			
					$sql.=" and (s.fecha_salida>='".$aI."-".$mI."-".$dI."' and s.fecha_salida<='".$aF."-".$mF."-".$dF."') ";				
			}			

			/////////////////////FILTRO POR TIPO DE PAGO//////////
			$sqlAux3=" select cod_tipo_pago from tipos_pago ";
			$respAux3=mysql_query($sqlAux3);
			$swAux=0;
			while($datAux3=mysql_fetch_array($respAux3)){
				$cod_tipo_pago=$datAux3[0];	
	
				if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
					if($swAux==0){
						$sql.=" and ( s.cod_tipo_pago=".$cod_tipo_pago."";
						$swAux=1;
					}else{				
						$sql.=" or s.cod_tipo_pago=".$cod_tipo_pago."";	
					}
		 	    }

			}	
			if($swAux==1){
				$sql.=" )";
			}	
			
			$resp = mysql_query($sql);
			$nro_filas_sql_venta=0;
			while($dat_aux=mysql_fetch_array($resp)){
				$nro_filas_sql_venta=$dat_aux[0];
				
			}


			////////////////////FIN SALIDAS POR VENTA//////////////////////////
			
			}						
			//////////////////////////////////////////	
			
						
?>
			<?php if(($nro_filas_sql_ot<>0) or ($nro_filas_sql_hr<>0) or ($nro_filas_sql_venta<>0)){?>
			<tr bgcolor="#FFFFCC">	
            	<td colspan="11" align="left" height="20"><strong><?php echo $nombre_cliente." Telf. ".$telefono_cliente." Cel. ".$celular_cliente." fax. ".$fax_cliente;?><?php if($codtipodoc==1 or $codtipodoc==0){ echo " Saldo Inicial HR: ".number_format($saldoInicialClienteHR,2);}?> <?php if($codtipodoc==2 or $codtipodoc==0){ echo " Saldo Inicial OT: ".number_format($saldoInicialClienteOT,2);}?> <?php if($codtipodoc==3 or $codtipodoc==0){ echo " Saldo Inicial VENTA: ".number_format($saldoInicialClienteVenta,2);}?><?php echo " Saldo Inicial Total:".number_format(($saldoInicialClienteHR+$saldoInicialClienteOT+$saldoInicialClienteVenta),2)." al: ".$dd."/".$mm."/".$aaaa;?></strong>
                </td>
            </tr>
             <?php }?>      
		<?php		
		if($codtipodoc==1 or $codtipodoc==0){
	///////////////////////////////////////////////////////////////////////////////////////////////////////

		 $sql=" select hr.cod_hoja_ruta, hr.cod_gestion, g.gestion, hr.nro_hoja_ruta, hr.fecha_hoja_ruta, ";
		 $sql.=" hr.cod_usuario_hoja_ruta, hr.obs_hoja_ruta, hr.cod_cotizacion, ";
		 $sql.=" hr.cod_estado_hoja_ruta, hr.factura_si_no, hr.cod_usuario_comision, hr.fecha_registro, ";
		 $sql.=" hr.cod_usuario_registro, hr.fecha_modifica, hr.cod_usuario_modifica, hr.cod_tipo_pago, hr.cod_estado_pago_doc ";
		 $sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
		 $sql.=" where hr.cod_cotizacion=c.cod_cotizacion ";
		 $sql.=" and hr.cod_gestion=g.cod_gestion ";
		 $sql.=" and hr.cod_estado_hoja_ruta<>2 ";
		 $sql.=" and hr.cod_estado_pago_doc<>3 ";
		 if($fecha_inicio<>"" and $fecha_final<>""){
			list($dI,$mI,$aI)=explode("/",$fecha_inicio);
			list($dF,$mF,$aF)=explode("/",$fecha_final);			
			$sql.=" and (hr.fecha_hoja_ruta>='".$aI."-".$mI."-".$dI."' and hr.fecha_hoja_ruta<='".$aF."-".$mF."-".$dF."')";		
		 }
		$sql.=" and c.cod_cliente=".$cod_cliente;
		/////////////////////FILTRO POR TIPO DE PAGO//////////
		$sqlAux3=" select cod_tipo_pago from tipos_pago ";
		$respAux3=mysql_query($sqlAux3);
		$swAux=0;
		while($datAux3=mysql_fetch_array($respAux3))
		{
			$cod_tipo_pago=$datAux3[0];	
			if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
				if($swAux==0){
					$sql.=" and ( hr.cod_tipo_pago=".$cod_tipo_pago."";
					$swAux=1;
				}else{				
					$sql.=" or hr.cod_tipo_pago=".$cod_tipo_pago."";	
				}
			}
		}	
		if($swAux==1){
			$sql.=" )";
		}
		/////////////////////FILTRO POR TIPO DE PAGO//////////	 
	 	$sql.=" order by hr.fecha_hoja_ruta  asc ";	
		
	    $resp = mysql_query($sql);  

		$totalDeudaClienteHR=0;
		$acuentaClienteHR=0;
		$saldoClienteHR=0;

		while($dat=mysql_fetch_array($resp)){


				$cod_hoja_ruta=$dat['cod_hoja_ruta'];
				$cod_gestion=$dat['cod_gestion']; 
				$gestionHojaRuta=$dat['gestion'];
				$nro_hoja_ruta=$dat['nro_hoja_ruta']; 
				$fecha_hoja_ruta=$dat['fecha_hoja_ruta']; 
				$cod_usuario_hoja_ruta=$dat['cod_usuario_hoja_ruta']; 
				$obs_hoja_ruta=$dat['obs_hoja_ruta']; 
				$cod_cotizacion=$dat['cod_cotizacion']; 
				$cod_estado_hoja_ruta=$dat['cod_estado_hoja_ruta']; 
				$factura_si_no=$dat['factura_si_no']; 
				$cod_usuario_comision=$dat['cod_usuario_comision']; 
				$fecha_registro=$dat['fecha_registro']; 
				$cod_usuario_registro=$dat['cod_usuario_registro']; 
				$fecha_modifica=$dat['fecha_modifica']; 
				$cod_usuario_modifica=$dat['cod_usuario_modifica']; 
				$cod_tipo_pago=$dat['cod_tipo_pago']; 	
							
				$sqlCotizacion=" select c.nro_cotizacion, g.gestion ";
				$sqlCotizacion.=" from cotizaciones c, gestiones g";
				$sqlCotizacion.=" where c.cod_gestion=g.cod_gestion";
				$sqlCotizacion.=" and c.cod_cotizacion=".$cod_cotizacion;
				$resp3 = mysql_query($sqlCotizacion);
				while($dat3=mysql_fetch_array($resp3)){
					$nro_cotizacion=$dat3['nro_cotizacion'];
					$gestion_cotizacion=$dat3['gestion'];
				}	
				

				///Tipo Pago Hoja Ruta//////
					$sql3="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$nombre_tipo_pago=$dat3['nombre_tipo_pago'];
					}
				////Fin Tipo Pago Hoja Ruta//
				$cod_estado_pago_doc=$dat['cod_estado_pago_doc']; 
				////////////////////////////////
				
							$monto_hojaruta=0;				
							$sqlAux=" select sum(cd.IMPORTE_TOTAL) ";
							$sqlAux.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
							$sqlAux.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
							$sqlAux.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
							$sqlAux.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){
								$monto_hojaruta=$datAux[0];
							}	
				////Descuento Cotizacion////////
					 $descuento_cotizacion=0;
						$sqlAux="select descuento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
						$respAux = mysql_query($sqlAux);
						while($datAux=mysql_fetch_array($respAux)){
							$descuento_cotizacion=$datAux[0];
						}
					
					 /////Fin descuento Cotizacion////////
				////Incremento Cotizacion////////
					 $incremento_cotizacion=0;
						$sqlAux="select incremento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
						$respAux = mysql_query($sqlAux);
						while($datAux=mysql_fetch_array($respAux)){
							$incremento_cotizacion=$datAux[0];
						}
					
					 /////Fin Incremento Cotizacion////////
					 					 
					 /////////A cuenta///////
					 	$sql8=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
					 	$sql8.=" from pagos_detalle pd, pagos p";
				 		$sql8.=" where pd.cod_pago=p.cod_pago";
					 	$sql8.=" and p.cod_estado_pago<>2";
					 	$sql8.=" and pd.codigo_doc=".$cod_hoja_ruta;
						$sql8.=" and pd.cod_tipo_doc=1";
						$resp8 = mysql_query($sql8);
						$acuenta_hojaruta=0;
						while($dat8=mysql_fetch_array($resp8)){
							$cod_moneda=$dat8['cod_moneda'];
							$monto_pago_detalle=$dat8['monto_pago_detalle'];
							$fecha_pago=$dat8['fecha_pago'];

							if($cod_moneda==1){
								$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
							}else{
									$sql3=" select cambio_bs from tipo_cambio";
									$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
									$sql3.=" and cod_moneda=".$cod_moneda;
									$resp3=mysql_query($sql3);
									$cambio_bs=0;
									while($dat3=mysql_fetch_array($resp3)){
										$cambio_bs=$dat3['cambio_bs'];
									}
									if($cambio_bs<>0){
										$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);							
									}
							}
						}						 
						///////Fin a cuenta////////////	
						

					list($a3,$m3,$d3)=explode("-",$fecha_hoja_ruta);

				


?>
<tr bgcolor="#FFFFFF" >	
    		<td align="left">HR</td>
            <td align="left"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"> <?php echo "HR.:".$nro_hoja_ruta."/".$gestionHojaRuta;?></a> <?php echo " TP.: ".$nombre_tipo_pago;?><a href="../reportes/impresionCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank"><?php echo "( Cot. ".$nro_cotizacion."/".$gestion_cotizacion." )";?></a></td>
            <td align="left"><?php echo $d3.".".$m3.".".$a3;?></td>
            <td align="right"><?php 
				$numNotasRemision=0;
				$sql3=" select count(*) from notas_remision  where cod_hoja_ruta='".$cod_hoja_ruta."'";
				$resp3= mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$numNotasRemision=$dat3[0];
				}

				if($numNotasRemision>0){
			?>
            <table border="0">
            <?php

					$sql3=" select cod_nota_remision, nro_nota_remision, cod_gestion,";
					$sql3.=" fecha_nota_remision, cod_usuario_nota_remision,";
					$sql3.=" obs_nota_remision, cod_estado_nota_remision ";
					$sql3.=" from notas_remision  where cod_hoja_ruta='".$cod_hoja_ruta."'";
					$resp3= mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						
						$cod_nota_remision=$dat3[0];
						$nro_nota_remision=$dat3[1];
						$cod_gestion_nota_remision=$dat3[2];
						$fecha_nota_remision=$dat3[3];
						$cod_usuario_nota_remision=$dat3[4];
						$obs_nota_remision=$dat3[5];
						$cod_estado_nota_remision=$dat3[6];
						
						$sql4=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario  ";
						$sql4.=" from usuarios where cod_usuario='".$cod_usuario_nota_remision."'";
						$UsuarioNotaRemision="";
						$resp4= mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4)){
							$UsuarioNotaRemision=$dat4[0]." ".$dat4[1];
						}
						$sql4="select gestion from gestiones where cod_gestion='".$cod_gestion_nota_remision."'";
						$resp4= mysql_query($sql4);
						$gestionNotaRemision="";
						while($dat4=mysql_fetch_array($resp4)){
							$gestionNotaRemision=$dat4[0];
						}
						list($a2,$m2,$d2)=explode("-",$fecha_nota_remision);

			?>
			<tr>
            <td><a href="../reportes/impresionNotaRemision.php?cod_nota_remision=<?php echo $cod_nota_remision; ?>" target="_blank"><?php echo "NR. ".$nro_nota_remision."/".$gestionNotaRemision."; ";?></a></td>
            <td><?php echo $d2.".".$m2.".".$a2;?></td>
            </tr>
			<?php	}?>
            </table>
			<?php }	?></td>
            <td align="right">
			<?php
			
     			$sqlAux=" select count(*)";
				$sqlAux.=" from pagos_detalle pd, pagos p, gestiones g, forma_pago fp, monedas m ";
				$sqlAux.=" where pd.cod_pago=p.cod_pago ";
				$sqlAux.=" and p.cod_gestion=g.cod_gestion ";
				$sqlAux.=" and pd.cod_forma_pago=fp.cod_forma_pago ";
				$sqlAux.=" and pd.cod_moneda=m.cod_moneda ";
				$sqlAux.=" and p.cod_estado_pago<>2 ";
				$sqlAux.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sqlAux.=" and pd.cod_tipo_doc=1";
				$respAux = mysql_query($sqlAux);
				$numPagosHR=0;
				while($datAux=mysql_fetch_array($respAux)){
					$numPagosHR=$datAux[0];
				}
				if($numPagosHR>0){	
				?>
                <table border="0" width="100%">
                <?php	
     			$sqlAux=" select p.nro_pago, p.cod_gestion, g.gestion,  pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago, "; 
				$sqlAux.=" pd.nro_comprobante, pd.fecha_comprobante, pd.cod_forma_pago, fp.desc_forma_pago,";
				$sqlAux.=" pd.cod_banco,pd.cod_moneda, m.abrev_moneda";
				$sqlAux.=" from pagos_detalle pd, pagos p, gestiones g, forma_pago fp, monedas m ";
				$sqlAux.=" where pd.cod_pago=p.cod_pago ";
				$sqlAux.=" and p.cod_gestion=g.cod_gestion ";
				$sqlAux.=" and pd.cod_forma_pago=fp.cod_forma_pago ";
				$sqlAux.=" and pd.cod_moneda=m.cod_moneda ";
				$sqlAux.=" and p.cod_estado_pago<>2 ";
				$sqlAux.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sqlAux.=" and pd.cod_tipo_doc=1";
				$sqlAux.=" order by  pd.fecha_comprobante desc, pd.nro_comprobante desc  ";
				$respAux = mysql_query($sqlAux);
				$monto_pago_detalle=0;
				while($datAux=mysql_fetch_array($respAux)){
					$nro_pago=$datAux['nro_pago'];
					$cod_gestion=$datAux['cod_gestion'];
					$gestionPago=$datAux['gestion'];
					$cod_moneda=$datAux['cod_moneda'];
					$monto_pago_detalle=$datAux['monto_pago_detalle'];
					$fecha_pago=$datAux['fecha_pago'];
					$nro_comprobante=$datAux['nro_comprobante'];
					$fecha_comprobante=$datAux['fecha_comprobante'];
					$cod_forma_pago=$datAux['cod_forma_pago'];
					$desc_forma_pago=$datAux['desc_forma_pago'];
					$cod_banco=$datAux['cod_banco'];
					$cod_moneda=$datAux['cod_moneda'];
					$abrev_moneda=$datAux['abrev_moneda'];	
					$cambio_bs=1;
					if($cod_moneda==1){
						$monto_pago_detalle=$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=1;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							$monto_pago_detalle=($monto_pago_detalle*$cambio_bs);

					}
					 list($a,$m,$d)=explode("-",$fecha_comprobante);
					 
				?>
                <tr>
                	<td align="left"><?php echo $d.".".$m.".".$a;?></td>
                    <td align="left"><?php echo $nro_comprobante;?></td>
                    <td align="right"><?php echo $monto_pago_detalle;?></td>
                </tr>
                <?php			
			}
			?>
            </table>
            <?php
			}
			?>
           </td>
            <td align="right">
			<?php echo number_format($monto_hojaruta,2);	 ?></td>
            <td align="right">
            		<?php  

					if($descuento_cotizacion>0){
						echo $descuento_cotizacion;
					}else{
						echo $descuento_cotizacion;
					}	
				?>
            </td>
            <td align="right">
                        		<?php  

					if($incremento_cotizacion>0){
						echo $incremento_cotizacion;
					}else{
						echo $incremento_cotizacion;
					}	
				?>
            </td> 
            <td align="right"><?php echo number_format((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion),2);?></td>
            <td align="right"><?php echo number_format($acuenta_hojaruta,2);?></td>
            <td align="right"><?php echo number_format(((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion)-$acuenta_hojaruta),2);?></td>       
   	  </tr>
<?php
						$totalDeudaClienteHR=$totalDeudaClienteHR+(($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion);
					$acuentaClienteHR=$acuentaClienteHR+$acuenta_hojaruta;
		 } 
?>
			<?php if($nro_filas_sql_hr<>0){?>
			<tr bgcolor="#DCF7D2">	
            	<td colspan="8" align="right"><strong>Total HR</strong></td>
	    		<td align="right"><?php echo number_format($totalDeudaClienteHR,2);?></td>
    	        <td align="right"><?php echo number_format($acuentaClienteHR,2);?></td>
        	    <td align="right"><?php echo number_format(($totalDeudaClienteHR-$acuentaClienteHR),2);?></td>
            </tr>
            <?php }?>
		
<?php

				$totalDeudaInventa=$totalDeudaInventa+$totalDeudaClienteHR;
				$aCuentaInventa=$aCuentaInventa+$acuentaClienteHR;
		}
?>
<?php if($codtipodoc==2 or $codtipodoc==0){	?>

		<?php
			
	///////////////////////////////////////////////////////////////////////////////////////////////////////


 	 $sql=" select ot.cod_orden_trabajo, ot.cod_gestion, g.gestion, ot.nro_orden_trabajo,ot.numero_orden_trabajo, ";
	 $sql.=" ot.fecha_orden_trabajo, ot.cod_est_ot,  ot.cod_estado_pago_doc, ot.monto_orden_trabajo,";
	 $sql.=" ot.cod_tipo_pago, ot.incremento_orden_trabajo, ot.descuento_orden_trabajo ";
	 $sql.=" from ordentrabajo ot,  gestiones g ";
	 $sql.=" where ot.cod_gestion=g.cod_gestion ";
	 $sql.=" and ot.cod_est_ot<>2 ";
	 $sql.=" and ot.cod_estado_pago_doc<>3 ";	
		 if($fecha_inicio<>"" and $fecha_final<>""){
			list($dI,$mI,$aI)=explode("/",$fecha_inicio);
			list($dF,$mF,$aF)=explode("/",$fecha_final);			
			$sql.=" and (ot.fecha_orden_trabajo>='".$aI."-".$mI."-".$dI."' and ot.fecha_orden_trabajo<='".$aF."-".$mF."-".$dF."')";		
		 }
		$sql.=" and ot.cod_cliente=".$cod_cliente;
		/////////////////////FILTRO POR TIPO DE PAGO//////////
		$sqlAux3=" select cod_tipo_pago from tipos_pago ";
		$respAux3=mysql_query($sqlAux3);
		$swAux=0;
		while($datAux3=mysql_fetch_array($respAux3))
		{
			$cod_tipo_pago=$datAux3[0];	
			if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
				if($swAux==0){
					$sql.=" and ( ot.cod_tipo_pago=".$cod_tipo_pago."";
					$swAux=1;
				}else{				
					$sql.=" or ot.cod_tipo_pago=".$cod_tipo_pago."";	
				}
			}
		}	
		if($swAux==1){
			$sql.=" )";
		}
		/////////////////////FILTRO POR TIPO DE PAGO//////////	 
	 	$sql.=" order by ot.fecha_orden_trabajo  asc ";	
	    $resp = mysql_query($sql);  


		$totalDeudaClienteOT=0;
		$acuentaClienteOT=0;
		$saldoClienteOT=0;

		while($dat=mysql_fetch_array($resp)){

				$cod_orden_trabajo=$dat['cod_orden_trabajo'];
				$cod_gestion=$dat['cod_gestion'];
				$gestion_orden_trabajo=$dat['gestion'];
				$nro_orden_trabajo=$dat['nro_orden_trabajo'];
				$numero_orden_trabajo=$dat['numero_orden_trabajo'];
				$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
				$cod_est_ot=$dat['cod_est_ot'];
				$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
				$monto_orden_trabajo=$dat['monto_orden_trabajo'];
				$cod_tipo_pago=$dat['cod_tipo_pago'];
				$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
				$descuento_orden_trabajo=$dat['descuento_orden_trabajo'];

				///Tipo Pago Hoja Ruta//////
					$sql3="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$nombre_tipo_pago=$dat3['nombre_tipo_pago'];
					}
				////Fin Tipo Pago Hoja Ruta//

					 					 
					 /////////A cuenta///////
					 	$sql8=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
					 	$sql8.=" from pagos_detalle pd, pagos p";
				 		$sql8.=" where pd.cod_pago=p.cod_pago";
					 	$sql8.=" and p.cod_estado_pago<>2";
					 	$sql8.=" and pd.codigo_doc=".$cod_orden_trabajo;
						$sql8.=" and pd.cod_tipo_doc=2";
						$resp8 = mysql_query($sql8);
						$acuenta_ordentrabajo=0;
						while($dat8=mysql_fetch_array($resp8)){
							$cod_moneda=$dat8['cod_moneda'];
							$monto_pago_detalle=$dat8['monto_pago_detalle'];
							$fecha_pago=$dat8['fecha_pago'];

							if($cod_moneda==1){
								$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
							}else{
									$sql3=" select cambio_bs from tipo_cambio";
									$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
									$sql3.=" and cod_moneda=".$cod_moneda;
									$resp3=mysql_query($sql3);
									$cambio_bs=0;
									while($dat3=mysql_fetch_array($resp3)){
										$cambio_bs=$dat3['cambio_bs'];
									}
									if($cambio_bs<>0){
										$acuenta_ordentrabajo=$acuenta_ordentrabajo+($monto_pago_detalle*$cambio_bs);							
									}
							}
						}						 
						///////Fin a cuenta////////////	
						

					list($a3,$m3,$d3)=explode("-",$fecha_orden_trabajo);

				


?>
<tr bgcolor="#FFFFFF" >	
    		<td align="left">OT</td>
            <td align="left"><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank"> <?php echo "OT.:".$nro_orden_trabajo."/".$gestion_orden_trabajo;?></a><?php echo " TP.: ".$nombre_tipo_pago;?></td>
            <td align="left"><?php echo $d3.".".$m3.".".$a3;?></td>


            <td align="right">&nbsp;</td>
            <td align="right">
			<?php
			
     			$sqlAux=" select count(*)";
				$sqlAux.=" from pagos_detalle pd, pagos p, gestiones g, forma_pago fp, monedas m ";
				$sqlAux.=" where pd.cod_pago=p.cod_pago ";
				$sqlAux.=" and p.cod_gestion=g.cod_gestion ";
				$sqlAux.=" and pd.cod_forma_pago=fp.cod_forma_pago ";
				$sqlAux.=" and pd.cod_moneda=m.cod_moneda ";
				$sqlAux.=" and p.cod_estado_pago<>2 ";
				$sqlAux.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sqlAux.=" and pd.cod_tipo_doc=2";
				$respAux = mysql_query($sqlAux);
				$numPagosOT=0;
				while($datAux=mysql_fetch_array($respAux)){
					$numPagosOT=$datAux[0];
				}
				if($numPagosOT>0){	
				?>
                <table border="0" width="100%">
                <?php	
     			$sqlAux=" select p.nro_pago, p.cod_gestion, g.gestion,  pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago, "; 
				$sqlAux.=" pd.nro_comprobante, pd.fecha_comprobante, pd.cod_forma_pago, fp.desc_forma_pago,";
				$sqlAux.=" pd.cod_banco,pd.cod_moneda, m.abrev_moneda";
				$sqlAux.=" from pagos_detalle pd, pagos p, gestiones g, forma_pago fp, monedas m ";
				$sqlAux.=" where pd.cod_pago=p.cod_pago ";
				$sqlAux.=" and p.cod_gestion=g.cod_gestion ";
				$sqlAux.=" and pd.cod_forma_pago=fp.cod_forma_pago ";
				$sqlAux.=" and pd.cod_moneda=m.cod_moneda ";
				$sqlAux.=" and p.cod_estado_pago<>2 ";
				$sqlAux.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sqlAux.=" and pd.cod_tipo_doc=2";
				$sqlAux.=" order by  pd.fecha_comprobante desc, pd.nro_comprobante desc  ";
				$respAux = mysql_query($sqlAux);
				$monto_pago_detalle=0;
				while($datAux=mysql_fetch_array($respAux)){
					$nro_pago=$datAux['nro_pago'];
					$cod_gestion=$datAux['cod_gestion'];
					$gestionPago=$datAux['gestion'];
					$cod_moneda=$datAux['cod_moneda'];
					$monto_pago_detalle=$datAux['monto_pago_detalle'];
					$fecha_pago=$datAux['fecha_pago'];
					$nro_comprobante=$datAux['nro_comprobante'];
					$fecha_comprobante=$datAux['fecha_comprobante'];
					$cod_forma_pago=$datAux['cod_forma_pago'];
					$desc_forma_pago=$datAux['desc_forma_pago'];
					$cod_banco=$datAux['cod_banco'];
					$cod_moneda=$datAux['cod_moneda'];
					$abrev_moneda=$datAux['abrev_moneda'];	
					$cambio_bs=1;
					if($cod_moneda==1){
						$monto_pago_detalle=$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=1;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							$monto_pago_detalle=($monto_pago_detalle*$cambio_bs);

					}
					 list($a,$m,$d)=explode("-",$fecha_comprobante);
					 
				?>
                <tr>
                	<td align="left"><?php echo $d.".".$m.".".$a;?></td>
                    <td align="left"><?php echo $nro_comprobante;?></td>
                    <td align="right"><?php echo $monto_pago_detalle;?></td>
                </tr>
                <?php			
			}
			?>
            </table>
            <?php
			}
			?>
           </td>
            <td align="right">
			<?php echo number_format(($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo,2);	 ?></td>
            <td align="right"><?php echo $descuento_orden_trabajo;?></td>
            <td align="right"><?php echo $incremento_orden_trabajo;?></td> 
            <td align="right"><?php echo number_format(($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo,2);?></td>
            <td align="right"><?php echo number_format($acuenta_ordentrabajo,2);?></td>
            <td align="right"><?php echo number_format(((($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo)-$acuenta_ordentrabajo),2);?></td>       
   	  </tr>
<?php
						$totalDeudaClienteOT=$totalDeudaClienteOT+(($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo);
					$acuentaClienteOT=$acuentaClienteOT+$acuenta_ordentrabajo;
		 } 
?>
	<?php if($nro_filas_sql_ot<>0){?>
			<tr bgcolor="#DCF7D2">	
            	<td colspan="8" align="right"><strong>Total OT</strong></td>
	    		<td align="right"><?php echo number_format($totalDeudaClienteOT,2);?></td>
    	        <td align="right"><?php echo number_format($acuentaClienteOT,2);?></td>
        	    <td align="right"><?php echo number_format(($totalDeudaClienteOT-$acuentaClienteOT),2);?></td>
            </tr>
     <?php }?>
		
<?php

				$totalDeudaInventa=$totalDeudaInventa+$totalDeudaClienteOT;
				$aCuentaInventa=$aCuentaInventa+$acuentaClienteOT;

?>


<?php		
		}
		
?>

<?php		
	if($codtipodoc==3 or $codtipodoc==0){
	///////////////////////////////////////////////////////////////////////////////////////////////////////

		 $sql=" select s.cod_salida, s.cod_gestion, g.gestion, s.nro_salida, s.fecha_salida, ";
		 $sql.=" s.obs_salida, s.cod_estado_salida, s.cod_estado_pago_doc, s.cod_tipo_pago ";
		 $sql.=" from salidas s, gestiones g";
		 $sql.=" where s.cod_gestion=g.cod_gestion ";
		 $sql.=" and s.cod_estado_salida<>2 ";
		 $sql.=" and s.cod_estado_pago_doc<>3 ";
		 if($fecha_inicio<>"" and $fecha_final<>""){
			list($dI,$mI,$aI)=explode("/",$fecha_inicio);
			list($dF,$mF,$aF)=explode("/",$fecha_final);			
			$sql.=" and (s.fecha_salida>='".$aI."-".$mI."-".$dI."' and s.fecha_salida<='".$aF."-".$mF."-".$dF."')";		
		 }
		$sql.=" and s.cod_cliente_venta=".$cod_cliente;
		/////////////////////FILTRO POR TIPO DE PAGO//////////
		$sqlAux3=" select cod_tipo_pago from tipos_pago ";
		$respAux3=mysql_query($sqlAux3);
		$swAux=0;
		while($datAux3=mysql_fetch_array($respAux3))
		{
			$cod_tipo_pago=$datAux3[0];	
			if($_POST['cod_tipo_pago'.$cod_tipo_pago]){
				if($swAux==0){
					$sql.=" and ( s.cod_tipo_pago=".$cod_tipo_pago."";
					$swAux=1;
				}else{				
					$sql.=" or s.cod_tipo_pago=".$cod_tipo_pago."";	
				}
			}
		}	
		if($swAux==1){
			$sql.=" )";
		}
		/////////////////////FILTRO POR TIPO DE PAGO//////////	 
	 	$sql.=" order by s.fecha_salida  asc ";	
		//echo $sql;
	    $resp = mysql_query($sql);  

		$totalDeudaClienteVenta=0;
		$acuentaClienteVenta=0;
		$saldoClienteVenta=0;

		while($dat=mysql_fetch_array($resp)){

				$cod_salida=$dat['cod_salida'];
				$cod_gestion=$dat['cod_gestion'];
				$gestionSalida=$dat['gestion'];
				$nro_salida=$dat['nro_salida'];
				$fecha_salida=$dat['fecha_salida'];
		 		$obs_salida=$dat['obs_salida'];
				$cod_estado_salida=$dat['cod_estado_salida'];
				$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
				$cod_tipo_pago=$dat['cod_tipo_pago'];

				///Tipo Pago //////
					$sql3="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$nombre_tipo_pago=$dat3['nombre_tipo_pago'];
					}
				////Fin Tipo Pago//

				////////////////////////////////
				
	 				$monto_venta=0;
			 		$sqlAux=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sqlAux.=" from salidas_detalle sd ";
					$sqlAux.=" where sd.cod_salida=".$cod_salida;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
						$monto_venta=$datAux[0];
					}
				

					 					 
				$sqlAux=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sqlAux.=" from pagos_detalle pd, pagos p";
			 	$sqlAux.=" where pd.cod_pago=p.cod_pago";
			 	$sqlAux.=" and p.cod_estado_pago<>2";
			 	$sqlAux.=" and pd.codigo_doc=".$cod_salida;
				$sqlAux.=" and pd.cod_tipo_doc=3";
				$respAux = mysql_query($sqlAux);
				$acuenta_venta=0;
				while($datAux=mysql_fetch_array($respAux)){
					$cod_moneda=$datAux['cod_moneda'];
					$monto_pago_detalle=$datAux['monto_pago_detalle'];
					$fecha_pago=$datAux['fecha_pago'];
					$fecha_pago=strftime("%Y-%m-%d",strtotime($fecha_pago));
					if($cod_moneda==1){
						$acuenta_venta=$acuenta_venta+$monto_pago_detalle;
					}else{
							$sqlAux2="select cambio_bs from tipo_cambio";
							$sqlAux2.="where fecha_tipo_cambio='".$fecha_pago."'";
							$sqlAux2.="and cod_moneda=".$cod_moneda;
							$respAux2= mysql_query($sqlAux2);
							$cambio_bs=0;
							while($datAux2=mysql_fetch_array($respAux2)){
								$cambio_bs=$datAux2['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_venta=$acuenta_venta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				

						

					list($a3,$m3,$d3)=explode("-",$fecha_salida);

				


?>
<tr bgcolor="#FFFFFF" >	
    		<td align="left">VENTA</td>
            <td align="left"><a href="../almacenes/detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank"> <?php echo "VENTA.:".$nro_salida."/".$gestionSalida;?></a> <?php echo " TP.: ".$nombre_tipo_pago;?></td>
            <td align="left"><?php echo $d3.".".$m3.".".$a3;?></td>
            <td align="right">&nbsp;</td>
            <td align="right">
			<?php
			
     			$sqlAux=" select count(*)";
				$sqlAux.=" from pagos_detalle pd, pagos p, gestiones g, forma_pago fp, monedas m ";
				$sqlAux.=" where pd.cod_pago=p.cod_pago ";
				$sqlAux.=" and p.cod_gestion=g.cod_gestion ";
				$sqlAux.=" and pd.cod_forma_pago=fp.cod_forma_pago ";
				$sqlAux.=" and pd.cod_moneda=m.cod_moneda ";
				$sqlAux.=" and p.cod_estado_pago<>2 ";
				$sqlAux.=" and pd.codigo_doc=".$cod_salida;
				$sqlAux.=" and pd.cod_tipo_doc=3";
				$respAux = mysql_query($sqlAux);
				$numPagosVenta=0;
				while($datAux=mysql_fetch_array($respAux)){
					$numPagosVenta=$datAux[0];
				}
				if($numPagosVenta>0){	
				?>
                <table border="0" width="100%">
                <?php	
     			$sqlAux=" select p.nro_pago, p.cod_gestion, g.gestion,  pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago, "; 
				$sqlAux.=" pd.nro_comprobante, pd.fecha_comprobante, pd.cod_forma_pago, fp.desc_forma_pago,";
				$sqlAux.=" pd.cod_banco,pd.cod_moneda, m.abrev_moneda";
				$sqlAux.=" from pagos_detalle pd, pagos p, gestiones g, forma_pago fp, monedas m ";
				$sqlAux.=" where pd.cod_pago=p.cod_pago ";
				$sqlAux.=" and p.cod_gestion=g.cod_gestion ";
				$sqlAux.=" and pd.cod_forma_pago=fp.cod_forma_pago ";
				$sqlAux.=" and pd.cod_moneda=m.cod_moneda ";
				$sqlAux.=" and p.cod_estado_pago<>2 ";
				$sqlAux.=" and pd.codigo_doc=".$cod_salida;
				$sqlAux.=" and pd.cod_tipo_doc=3";
				$sqlAux.=" order by  pd.fecha_comprobante desc, pd.nro_comprobante desc  ";
				$respAux = mysql_query($sqlAux);
				$monto_pago_detalle=0;
				while($datAux=mysql_fetch_array($respAux)){
					$nro_pago=$datAux['nro_pago'];
					$cod_gestion=$datAux['cod_gestion'];
					$gestionPago=$datAux['gestion'];
					$cod_moneda=$datAux['cod_moneda'];
					$monto_pago_detalle=$datAux['monto_pago_detalle'];
					$fecha_pago=$datAux['fecha_pago'];
					$nro_comprobante=$datAux['nro_comprobante'];
					$fecha_comprobante=$datAux['fecha_comprobante'];
					$cod_forma_pago=$datAux['cod_forma_pago'];
					$desc_forma_pago=$datAux['desc_forma_pago'];
					$cod_banco=$datAux['cod_banco'];
					$cod_moneda=$datAux['cod_moneda'];
					$abrev_moneda=$datAux['abrev_moneda'];	
					$cambio_bs=1;
					if($cod_moneda==1){
						$monto_pago_detalle=$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=1;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							$monto_pago_detalle=($monto_pago_detalle*$cambio_bs);

					}
					 list($a,$m,$d)=explode("-",$fecha_comprobante);
					 
				?>
                <tr>
                	<td align="left"><?php echo $d.".".$m.".".$a;?></td>
                    <td align="left"><?php echo $nro_comprobante;?></td>
                    <td align="right"><?php echo $monto_pago_detalle;?></td>
                </tr>
                <?php			
			}
			?>
            </table>
            <?php
			}
			?>
           </td>
            <td align="right">
			<?php echo number_format($monto_venta,2);	 ?></td>
            <td align="right">&nbsp; </td>
            <td align="right">&nbsp;</td> 
            <td align="right"><?php echo number_format($monto_venta,2);?></td>
            <td align="right"><?php echo number_format($acuenta_venta,2);?></td>
            <td align="right"><?php echo number_format(($monto_venta-$acuenta_venta),2);?></td>       
   	  </tr>
<?php
						$totalDeudaClienteVenta=$totalDeudaClienteVenta+$monto_venta;
					$acuentaClienteVenta=$acuentaClienteVenta+$acuenta_venta;
		 } 
?>
			<?php if($nro_filas_sql_venta<>0){?>
			<tr bgcolor="#DCF7D2">	
            	<td colspan="8" align="right"><strong>Total VENTA</strong></td>
	    		<td align="right"><?php echo number_format($totalDeudaClienteVenta,2);?></td>
    	        <td align="right"><?php echo number_format($acuentaClienteVenta,2);?></td>
        	    <td align="right"><?php echo number_format(($totalDeudaClienteVenta-$acuentaClienteVenta),2);?></td>
            </tr>
            <?php }?>
		
<?php

				$totalDeudaInventa=$totalDeudaInventa+$totalDeudaClienteVenta;
				$aCuentaInventa=$aCuentaInventa+$acuentaClienteVenta;
		}
?>
<?php if($nro_filas_sql_hr<>0 or $nro_filas_sql_ot<>0 or $nro_filas_sql_venta<>0){?>
			<tr bgcolor="#DCF7D2">	
            	<td colspan="8" align="right"><strong>Total Cliente</strong></td>
	    		<td align="right"><?php echo number_format(($totalDeudaClienteOT+$totalDeudaClienteHR+$totalDeudaClienteVenta),2);?></td>
    	        <td align="right"><?php echo number_format(($acuentaClienteOT+$acuentaClienteHR+$acuentaClienteVenta),2);?></td>
        	    <td align="right"><?php echo number_format(($totalDeudaClienteOT-$acuentaClienteOT)+($totalDeudaClienteHR-$acuentaClienteHR)+($totalDeudaClienteVenta-$acuentaClienteVenta),2);?></td>
            </tr>
<?php } ?>
<?php }	?>


	<tr bgcolor="#FF99FF">	
           	<td colspan="8" align="right"><strong>TOTALES</strong></td>
	    	<td align="right" title="Total"><?php echo number_format($totalDeudaInventa,2);?></td>
    	    <td align="right" title="A cuenta"><?php echo number_format($aCuentaInventa,2);?></td>
        	<td align="right" title="Saldo"><?php echo number_format(($totalDeudaInventa-$aCuentaInventa),2);?></td>
   </tr>

<?php
	}
?>
</table>

    <?php
     $fechaInicial=$aI."-".$mI."-".$dI;
	 $dias=1;
	 
	 $fechaSaldoInicialInventa=date("Y-m-d", strtotime("$fechaInicial -$dias day"));
	 list($aaaa,$mm,$dd)=explode("-",$fechaSaldoInicialInventa);
	?>
    <br/>
    <div align="center" style="background:#FFF;font-size: 14px;color: #000;font-weight:bold;"><?php echo "SALDO ANTERIOR CON LOS PARAMETROS SELECCIONADOS: ".number_format($saldoInicialInventa,2)." A FECHA :".$dd."/".$mm."/".$aaaa;?></div>
</div>	
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>


